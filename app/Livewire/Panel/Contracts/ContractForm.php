<?php

namespace App\Livewire\Panel\Contracts;

use App\Models\Contract;
use App\Models\FirstChargeMode;
use App\Models\RecurrenceUnit;
use App\Models\Status;
use App\Models\UserPaymentGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.panel')]
class ContractForm extends Component
{
    public ?Contract $contract = null;

    // Main
    public string $name = '';
    public ?string $description = null;

    // Defaults
    public string $default_amount = '0.00';
    public string $default_currency = 'BRL';
    public ?int $default_due_day = null;
    public ?int $default_due_days_after_issue = null;

    // Recurrence
    public ?int $recurrence_unit_id = null;
    public int $recurrence_interval = 1;

    // First charge
    public ?int $first_charge_mode_id = null;
    public ?string $first_charge_date = null; // YYYY-MM-DD

    // Gateway + status
    public ?int $user_payment_gateway_id = null;
    public ?int $status_id = null;

    public ?string $starts_at = null; // YYYY-MM-DD
    public ?string $ends_at = null;   // YYYY-MM-DD

    public function mount(?int $contractId = null): void
    {
        if ($contractId) {
            $this->contract = Contract::query()
                ->where('user_id', Auth::id())
                ->findOrFail($contractId);

            $this->fill([
                'name' => $this->contract->name,
                'description' => $this->contract->description,
                'default_amount' => (string) $this->contract->default_amount,
                'default_currency' => $this->contract->default_currency,
                'default_due_day' => $this->contract->default_due_day,
                'default_due_days_after_issue' => $this->contract->default_due_days_after_issue,
                'recurrence_unit_id' => $this->contract->recurrence_unit_id,
                'recurrence_interval' => $this->contract->recurrence_interval,
                'first_charge_mode_id' => $this->contract->first_charge_mode_id,
                'first_charge_date' => optional($this->contract->first_charge_date)->format('Y-m-d'),
                'user_payment_gateway_id' => $this->contract->user_payment_gateway_id,
                'status_id' => $this->contract->status_id,
                'starts_at' => optional($this->contract->starts_at)->format('Y-m-d'),
                'ends_at' => optional($this->contract->ends_at)->format('Y-m-d'),
            ]);

            return;
        }

        // Create defaults
        $this->status_id = Status::query()
            ->where('scope', 'contract')
            ->where('key', 'draft')
            ->value('id');

        $this->recurrence_unit_id = RecurrenceUnit::query()
            ->where('key', 'month')
            ->value('id');

        $this->first_charge_mode_id = FirstChargeMode::query()
            ->where('key', 'next_period')
            ->value('id');

        $this->user_payment_gateway_id = UserPaymentGateway::query()
            ->where('user_id', Auth::id())
            ->where('is_default', true)
            ->value('id');
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],

            'default_amount' => ['required', 'numeric', 'min:0'],
            'default_currency' => ['required', 'string', 'size:3'],

            'default_due_day' => ['nullable', 'integer', 'min:1', 'max:28'],
            'default_due_days_after_issue' => ['nullable', 'integer', 'min:0', 'max:365'],

            'recurrence_unit_id' => ['required', 'integer', Rule::exists('recurrence_units', 'id')],
            'recurrence_interval' => ['required', 'integer', 'min:1', 'max:24'],

            'first_charge_mode_id' => ['required', 'integer', Rule::exists('first_charge_modes', 'id')],
            'first_charge_date' => ['nullable', 'date_format:Y-m-d'],

            'user_payment_gateway_id' => [
                'required',
                'integer',
                Rule::exists('user_payment_gateways', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],

            'status_id' => [
                'required',
                'integer',
                Rule::exists('statuses', 'id')->where(fn ($q) => $q->where('scope', 'contract')),
            ],

            'starts_at' => ['nullable', 'date_format:Y-m-d'],
            'ends_at' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:starts_at'],
        ]);

        // Business rule: choose ONE due rule (or none)
        if ($this->default_due_day && $this->default_due_days_after_issue) {
            $this->addError('default_due_day', 'Choose either "Due day" OR "Due days after issue", not both.');
            $this->addError('default_due_days_after_issue', 'Choose either "Due day" OR "Due days after issue", not both.');
            return;
        }

        // If first charge mode is "fixed_date", date is required
        $fixedModeId = FirstChargeMode::query()->where('key', 'fixed_date')->value('id');
        if ((int) $this->first_charge_mode_id === (int) $fixedModeId && ! $this->first_charge_date) {
            $this->addError('first_charge_date', 'First charge date is required when mode is Fixed Date.');
            return;
        }

        $payload = [
            'user_id' => Auth::id(),
            'status_id' => $this->status_id,
            'user_payment_gateway_id' => $this->user_payment_gateway_id,

            'name' => $this->name,
            'description' => $this->description,

            'default_amount' => $this->default_amount,
            'default_currency' => strtoupper($this->default_currency),

            'default_due_day' => $this->default_due_day,
            'default_due_days_after_issue' => $this->default_due_days_after_issue,

            'recurrence_unit_id' => $this->recurrence_unit_id,
            'recurrence_interval' => $this->recurrence_interval,

            'first_charge_mode_id' => $this->first_charge_mode_id,
            'first_charge_date' => $this->first_charge_date,

            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
        ];

        if ($this->contract) {
            $this->contract->update($payload);
            session()->flash('success', 'Contract updated successfully.');
            return;
        }

        $this->contract = Contract::create($payload);

        session()->flash('success', 'Contract created successfully.');
        redirect()->route('panel.contracts.edit', $this->contract->id);
    }

    public function getIsEditProperty(): bool
    {
        return (bool) $this->contract;
    }

    public function getContractStatusesProperty()
    {
        return Status::query()
            ->where('scope', 'contract')
            ->orderBy('label')
            ->get(['id', 'label']);
    }

    public function getRecurrenceUnitsProperty()
    {
        return RecurrenceUnit::query()
            ->orderBy('label')
            ->get(['id', 'label']);
    }

    public function getFirstChargeModesProperty()
    {
        return FirstChargeMode::query()
            ->orderBy('label')
            ->get(['id', 'label']);
    }

    public function getUserGatewaysProperty()
    {
        return UserPaymentGateway::query()
            ->where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.panel.contracts.contract-form');
    }
}
