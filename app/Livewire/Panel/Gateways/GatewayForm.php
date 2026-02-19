<?php

namespace App\Livewire\Panel\Gateways;

use App\Models\PaymentProvider;
use App\Models\Status;
use App\Models\UserPaymentGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.panel')]
class GatewayForm extends Component
{
    public ?UserPaymentGateway $gateway = null;

    public string $provider_key = 'mercadopago';
    public string $name = 'Mercado Pago';
    public bool $is_default = false;
    public ?int $status_id = null;

    public ?string $mp_access_token = null;
    public ?string $mp_public_key = null;

    public function mount(?UserPaymentGateway $gateway = null): void
    {
        $this->status_id = Status::query()
            ->where('scope', 'gateway_connection')
            ->where('key', 'active')
            ->value('id');

        // CREATE
        if (! $gateway) {
            $this->is_default = ! UserPaymentGateway::query()
                ->where('user_id', Auth::id())
                ->exists();

            $this->name = 'Mercado Pago';
            return;
        }

        // SECURITY: ensure the gateway belongs to the logged user
        abort_unless($gateway->user_id === Auth::id(), 404);

        // EDIT
        $this->gateway = $gateway;
        $this->name = $gateway->name;
        $this->is_default = (bool) $gateway->is_default;
        $this->status_id = $gateway->status_id;

        $this->provider_key = PaymentProvider::query()
            ->whereKey($gateway->payment_provider_id)
            ->value('key') ?? 'mercadopago';

        // Fill masked credentials
        if ($gateway->credentials_encrypted) {
            $json = Crypt::decryptString($gateway->credentials_encrypted);
            $data = json_decode($json, true) ?: [];

            $access = (string) ($data['access_token'] ?? '');
            $public = (string) ($data['public_key'] ?? '');

            $this->mp_access_token = $access !== '' ? $this->maskSecret($access) : null;
            $this->mp_public_key   = $public !== '' ? $this->maskSecret($public) : null;
        }
    }

    public function save(): void
    {
        $providerId = PaymentProvider::query()
            ->where('key', 'mercadopago')
            ->value('id');

        if (! $providerId) {
            $this->addError('provider_key', 'Mercado Pago provider is not seeded in payment_providers.');
            return;
        }

        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'is_default' => ['boolean'],

            'status_id' => [
                'required',
                'integer',
                Rule::exists('statuses', 'id')->where(fn ($q) => $q->where('scope', 'gateway_connection')),
            ],

            // On create: required. On edit: can keep masked.
            'mp_access_token' => [$this->gateway ? 'nullable' : 'required', 'string', 'min:10', 'max:500'],
            'mp_public_key'   => ['nullable', 'string', 'min:10', 'max:500'],
        ]);

        // If editing, load real secrets so masked values can be preserved
        $existing = ['access_token' => null, 'public_key' => null];

        if ($this->gateway?->credentials_encrypted) {
            $json = Crypt::decryptString($this->gateway->credentials_encrypted);
            $data = json_decode($json, true) ?: [];
            $existing['access_token'] = $data['access_token'] ?? null;
            $existing['public_key']   = $data['public_key'] ?? null;
        }

        $finalAccess = $this->mp_access_token;
        $finalPublic = $this->mp_public_key;

        // Keep old secret if user kept masked value
        if (is_string($finalAccess) && str_contains($finalAccess, '*')) {
            $finalAccess = $existing['access_token'];
        }
        if (is_string($finalPublic) && str_contains($finalPublic, '*')) {
            $finalPublic = $existing['public_key'];
        }

        if (! $finalAccess) {
            $this->addError('mp_access_token', 'Access Token is required.');
            return;
        }

        // If set as default: unset other defaults for this user
        if ($this->is_default) {
            UserPaymentGateway::query()
                ->where('user_id', Auth::id())
                ->when($this->gateway, fn ($q) => $q->where('id', '!=', $this->gateway->id))
                ->update(['is_default' => false]);
        }

        $encrypted = Crypt::encryptString(json_encode([
            'provider' => 'mercadopago',
            'access_token' => $finalAccess,
            'public_key' => $finalPublic,
        ]));

        $payload = [
            'user_id' => Auth::id(),
            'payment_provider_id' => $providerId,
            'status_id' => $this->status_id,
            'name' => $this->name,
            'is_default' => $this->is_default,
            'credentials_encrypted' => $encrypted,
            'webhook_secret_encrypted' => null,
        ];

        // EDIT
        if ($this->gateway) {
            $this->gateway->update($payload);

            // refresh masked fields after save
            $this->mp_access_token = $this->maskSecret($finalAccess);
            $this->mp_public_key = $finalPublic ? $this->maskSecret($finalPublic) : null;

            session()->flash('success', 'Gateway updated successfully.');
            return;
        }

        // CREATE
        $created = UserPaymentGateway::create($payload);
        session()->flash('success', 'Gateway created successfully.');
        redirect()->route('panel.gateways.edit', $created->id);
    }

    public function delete(): void
    {

        if (! $this->gateway) {
            abort(404);
        }

        // Safety: ensure ownership
        abort_unless($this->gateway->user_id === Auth::id(), 404);

        // OPTION A (recommended): soft-delete-like behavior using status "revoked"
        $revokedId = Status::query()
            ->where('scope', 'gateway_connection')
            ->where('key', 'revoked')
            ->value('id');
        ds($revokedId);
        if ($revokedId) {
            $this->gateway->update([
                'status_id' => $revokedId,
                'is_default' => false,
            ]);
        } else {
            // OPTION B fallback: hard delete if revoked status doesn't exist
            $this->gateway->delete();
        }
        session()->flash('success', 'Gateway removed successfully.');
        redirect()->route('panel.gateways'); // your gateways list route
    }

    private function maskSecret(string $value): string
    {
        $value = trim($value);
        $len = strlen($value);

        if ($len <= 10) {
            return str_repeat('*', $len);
        }

        return substr($value, 0, 6) . str_repeat('*', max(6, $len - 10)) . substr($value, -4);
    }

    public function getIsEditProperty(): bool
    {
        return (bool) $this->gateway;
    }

    public function getGatewayStatusesProperty()
    {
        return Status::query()
            ->where('scope', 'gateway_connection')
            ->orderBy('label')
            ->get(['id', 'label']);
    }

    public function render()
    {
        return view('livewire.panel.gateways.gateway-form');
    }
}
