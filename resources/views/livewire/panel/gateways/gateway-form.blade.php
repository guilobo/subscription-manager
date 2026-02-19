<div class="space-y-6">
    <x-card
        title="{{ $this->isEdit ? 'Edit Payment Gateway' : 'Add Payment Gateway' }}"
        subtitle="Configure your Mercado Pago credentials to create and charge invoices."
    >
        @if (session('success'))
            <x-alert type="success" class="mb-4">
                {{ session('success') }}
            </x-alert>
        @endif

        {{-- Provider selection (for now only Mercado Pago) --}}
        <div class="space-y-2">
            <div class="text-sm font-semibold">Provider</div>

            <label class="block">
                <input type="radio" class="hidden" wire:model="provider_key" value="mercadopago" />
                <div class="border rounded-xl p-4 flex items-center gap-4 cursor-pointer
                            {{ $provider_key === 'mercadopago' ? 'ring-2 ring-primary' : '' }}">
                    <div class="w-12 h-12 flex items-center justify-center bg-white rounded-lg">
                        <img
                            src="https://arts-logo.b-cdn.net/Logos/gateways/MP_RGB_HANDSHAKE_color_vertical.svg"
                            alt="Mercado Pago"
                            class="w-10 h-10 object-contain"
                        />
                    </div>
                    <div>
                        <div class="font-semibold">Mercado Pago</div>
                        <div class="text-sm opacity-70">Use your Mercado Pago API credentials to charge your clients.</div>
                    </div>
                </div>
            </label>

            @error('provider_key')
            <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        {{-- Basic settings --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <x-input label="Connection Name" wire:model.defer="name" placeholder="e.g. Mercado Pago - Main" required />
            <x-toggle label="Default Gateway" wire:model.defer="is_default" />
            <x-select
                label="Status"
                wire:model.defer="status_id"
                :options="$this->gatewayStatuses"
                option-value="id"
                option-label="label"
                required
            />

        </div>

            <div class="divider my-6" ></div>

        {{-- Mercado Pago credentials --}}
        <div class="space-y-4">
            <div>
                <div class="font-semibold">Mercado Pago Credentials</div>
                <div class="text-sm opacity-70">These values are stored encrypted in the database.</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input
                    label="Access Token"
                    wire:model.defer="mp_access_token"
                    placeholder="APP_USR-xxxxxxxxxxxxxxxxxxxx"
                    required
                />

                <x-input
                    label="Public Key (optional)"
                    wire:model.defer="mp_public_key"
                    placeholder="APP_USR-xxxxxxxxxxxxxxxxxxxx"
                />
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Back" link="{{ route('panel.gateways') }}" class="btn-ghost" />
            <x-button
                label="{{ $this->isEdit ? 'Save Changes' : 'Create Gateway' }}"
                wire:click="save"
                spinner="save"
                class="btn-primary"
            />
        </x-slot:actions>
    </x-card>
</div>
