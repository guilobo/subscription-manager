<div @click.stop="true">
    <x-mary-modal
        wire:model="registerModal"
        :subtitle="__('Enter your details below to create your account')"
        :title="__('Create an account')"
        class="backdrop-blur">
        <x-form wire:submit="register()" no-separator>
            <x-mary-input
                :label="__('Name')"
                wire:model="name"
                :placeholder="__('Full name')"
                icon="o-user"
            />
            <x-mary-input
                label="{{__('E-Mail Address')}}"
                wire:model="email"
                type="email"/>
            <x-password
                label="{{__('Password')}}"
                wire:model="password"
                clearable  />
            <x-password
                label="{{__('Confirm password')}}"
                wire:model="password_confirmation"
                clearable  />

            <x-slot:actions>
                <x-mary-button
                    label="{{__('Register')}}"
                    class="btn-primary"
                    type="submit"
                    spinner="register" />
                <x-mary-button label="Cancel" @click="$wire.registerModal = false" />
            </x-slot:actions>
        </x-form>
    </x-mary-modal>


    @if($showButton)
        <div class="flex justify-center">
            <x-mary-button
                :label="$buttonLabel??__('Open')"
                @click="$wire.registerModal = true"
                class=""
            />
        </div>
    @endif
</div>
