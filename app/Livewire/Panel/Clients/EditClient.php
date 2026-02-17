<?php

namespace App\Livewire\Panel\Clients;

use App\Models\Client;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.panel')]
class EditClient extends Component
{
    public ?Client $client = null;

    public string $name = '';
    public ?string $email = null;
    public ?string $document = null;
    public ?string $phone = null;
    public ?int $status_id = null;

    public string $country_code = '55'; // default Brazil
    public string $phone_number = '';


    public function mount(?int $clientId = null): void
    {
        if ($this->client && $this->client->phone) {
            $full = preg_replace('/\D/', '', $this->client->phone);

            if (str_starts_with($full, '55')) {
                $this->country_code = '55';
                $this->phone_number = substr($full, 2);
            } else {
                $this->phone_number = $full;
            }
        }


        if ($clientId) {
            $this->client = Client::query()
                ->where('user_id', Auth::id())
                ->findOrFail($clientId);

            $this->fill([
                'name'      => $this->client->name,
                'email'     => $this->client->email,
                'document'  => $this->client->document,
                'phone'     => $this->client->phone,
                'status_id' => $this->client->status_id,
            ]);

            return;
        }

        // Create mode: default status = active (client scope)
        $this->status_id = Status::query()
            ->where('scope', 'client')
            ->where('key', 'active')
            ->value('id');
    }

    public function save(): void
    {
        $this->validate([
            'name'      => ['required', 'string', 'min:2', 'max:255'],
            'email'     => ['nullable', 'email', 'max:255'],
            'document'  => ['nullable', 'string', 'max:50'],
            'country_code' => ['required', 'string'],
            'phone_number' => ['nullable', 'regex:/^[0-9]+$/'],
            'status_id' => [
                'required',
                'integer',
                Rule::exists('statuses', 'id')->where(fn ($q) => $q->where('scope', 'client')),
            ],
        ]);

        if ($this->phone_number) {

            if ($this->country_code === '55') {
                if (!preg_match('/^[0-9]{10,11}$/', $this->phone_number)) {
                    $this->addError('phone_number', 'Brazil phone must contain 10 or 11 digits.');
                    return;
                }
            }

        }


        if ($this->client) {
            $phone = $this->phone_number
                ? $this->country_code . $this->phone_number
                : null;

            $this->client->update([
                'name'      => $this->name,
                'email'     => $this->email,
                'document'  => $this->document,
                'phone'     => $phone,
                'status_id' => $this->status_id,
            ]);

            session()->flash('success', 'Client updated successfully.');
            return;
        }

        $this->client = Client::create([
            'user_id'   => Auth::id(),
            'name'      => $this->name,
            'email'     => $this->email,
            'document'  => $this->document,
            'phone'     => $this->phone,
            'status_id' => $this->status_id,
        ]);

        session()->flash('success', 'Client created successfully.');

        // Optional: redirect to edit mode after create
        redirect()->route('panel.clients.edit', $this->client->id);
    }

    public function getClientStatusesProperty()
    {
        return Status::query()
            ->where('scope', 'client')
            ->orderBy('label')
            ->get(['id', 'label']);
    }

    public function getIsEditProperty(): bool
    {
        return (bool) $this->client;
    }

    public function render()
    {
        return view('livewire.panel.clients.edit-client');
    }
}
