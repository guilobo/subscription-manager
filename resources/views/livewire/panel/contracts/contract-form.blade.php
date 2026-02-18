<div class="space-y-6">
    <x-card
        title="{{ $this->isEdit ? 'Edit Contract' : 'Create Contract' }}"
        subtitle="Configure pricing, recurrence, gateway, and first charge rules."
    >
        @if (session('success'))
            <x-alert type="success" class="mb-4">
                {{ session('success') }}
            </x-alert>
        @endif

        {{-- Main --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Name" wire:model.defer="name" placeholder="e.g. Monthly Retainer" required />
            <x-select
                label="Status"
                wire:model.defer="status_id"
                :options="$this->contractStatuses"
                option-value="id"
                option-label="label"
                required
            />
        </div>

        <x-textarea label="Description" wire:model.defer="description" placeholder="Optional notes..." />

        {{-- Defaults --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-input label="Default Amount" wire:model.defer="default_amount" type="number" step="0.01" required />
            <x-input label="Currency" wire:model.defer="default_currency" maxlength="3" placeholder="BRL" required />
            <x-select
                label="Gateway"
                wire:model.defer="user_payment_gateway_id"
                :options="$this->userGateways"
                option-value="id"
                option-label="name"
                required
            />
        </div>

        {{-- Due rules --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Due Day (1-28)"
                wire:model.defer="default_due_day"
                type="number"
                min="1"
                max="28"
                placeholder="e.g. 5"
            />

            <x-input
                label="Due Days After Issue"
                wire:model.defer="default_due_days_after_issue"
                type="number"
                min="0"
                max="365"
                placeholder="e.g. 7"
            />
        </div>
        <p class="text-sm opacity-70">
            Use <strong>either</strong> "Due Day" or "Due Days After Issue". Leave both empty if due date is defined by the gateway.
        </p>

        {{-- Recurrence --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select
                label="Recurrence Unit"
                wire:model.defer="recurrence_unit_id"
                :options="$this->recurrenceUnits"
                option-value="id"
                option-label="label"
                required
            />

            <x-input
                label="Recurrence Interval"
                wire:model.defer="recurrence_interval"
                type="number"
                min="1"
                max="24"
                placeholder="e.g. 1, 2, 3, 6, 12"
                required
            />
        </div>

        {{-- First charge --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select
                label="First Charge Mode"
                wire:model.defer="first_charge_mode_id"
                :options="$this->firstChargeModes"
                option-value="id"
                option-label="label"
                required
            />

            <x-input
                label="First Charge Date (when Fixed Date)"
                wire:model.defer="first_charge_date"
                type="date"
            />
        </div>

        {{-- Lifetime --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Starts At" wire:model.defer="starts_at" type="date" />
            <x-input label="Ends At" wire:model.defer="ends_at" type="date" />
        </div>

        <x-slot:actions>
            <x-button label="Back" link="{{ route('panel.contracts') }}" class="btn-ghost" />
            <x-button
                label="{{ $this->isEdit ? 'Save Changes' : 'Create Contract' }}"
                wire:click="save"
                spinner="save"
                class="btn-primary"
            />
        </x-slot:actions>
    </x-card>
</div>
