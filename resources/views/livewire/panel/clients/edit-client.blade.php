<div class="space-y-6">
    <x-card
        title="{{ $this->isEdit ? 'Edit Client' : 'Create Client' }}"
        subtitle="{{ $this->isEdit ? 'Update client details.' : 'Add a new client to receive recurring charges.' }}"
    >
        @if (session('success'))
            <x-alert type="success" class="mb-4">
                {{ session('success') }}
            </x-alert>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-mary-input
                label="Name"
                placeholder="Client name"
                wire:model.defer="name"
                required
            />

            <x-select
                label="Status"
                wire:model.defer="status_id"
                :options="$this->clientStatuses"
                option-value="id"
                option-label="label"
                required
            />
        </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="flex gap-2">
                    <div class="w-32">
                        <x-select
                            label="Country"
                            wire:model="country_code"
                            :options="[
                    ['id' => '55', 'label' => '🇧🇷 +55 Brazil'],
                    ['id' => '1',  'label' => '🇺🇸 +1 USA'],
                    ['id' => '44', 'label' => '🇬🇧 +44 UK'],
                ]"
                            option-value="id"
                            option-label="label"
                        />
                    </div>

                    <div class="flex-1">
                        <x-mary-input
                            label="Phone"
                            type="number"
                            placeholder="Only numbers"
                            wire:model.defer="phone_number"
                            inputmode="numeric"
                            pattern="[0-9]*"
                        />
                    </div>
                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-mary-input
                label="Document"
                placeholder="CPF/CNPJ (optional)"
                wire:model.defer="document"
            />
        </div>

        <x-slot:actions>
            <x-mary-button
                label="Back"
                link="{{ route('panel.clients') }}"
                class="btn-ghost"
            />

            <x-mary-button
                label="{{ $this->isEdit ? 'Save Changes' : 'Create Client' }}"
                wire:click="save"
                spinner="save"
                class="btn-primary"
            />
        </x-slot:actions>
    </x-card>
</div>
