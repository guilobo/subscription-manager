<div>
    <x-mary-button
        icon="o-user"
        @click="$wire.showDrawerLogin = true"
        class="btn-circle"
    />
    @guest
        <x-drawer
            wire:model="showDrawerLogin"
            :title="__('Log in to your account')"
            :subtitle="__('Enter your email and password below to log in')"
            separator
            with-close-button
            close-on-escape
            class="w-11/12 lg:w-1/3"
            right
        >


            <x-form wire:submit="login" no-separator @click.stop="">
                <x-mary-input
                    id="login-email"
                    label="{{__('E-Mail Address')}}"
                    wire:model="email"
                    type="email"
                />

                <x-password
                    id="login-password"
                    label="{{__('Password')}}"
                    wire:model="password"
                    clearable
                />
{{--                <a href="{{route('password.request')}}" wire:navigate> {{ __('Forgot your password?') }} </a>--}}
                <x-checkbox wire:model="remember" :label="__('Remember me')"/>


                <x-slot:actions>
                    <x-button
                        label="{{__('Log in')}}"
                        class="btn-primary w-full"
                        type="submit"
                        spinner="login"/>
                </x-slot:actions>
            </x-form>
            <div class="divider">{{__('Or')}}</div>
                <livewire:helpers.register-modal
                    :showButton="true"
                    buttonLabel="{!! __('Don\'t have an account?') !!} {{ __('Sign up') }}"
                />

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.showDrawerLogin = false"/>
                {{--            <x-mary-button label="Confirm" class="btn-primary" icon="o-check" />--}}
            </x-slot:actions>
        </x-drawer>
    @endguest

    {{-----------------------------------------}}
    @auth
        <x-drawer
            wire:model="showDrawerLogin"
            with-close-button
            close-on-escape
            class="w-11/12 lg:w-1/3"
            right
        >
            <div class="flex justify-center items-center gap-2">
                <div class="">
                    <div class="avatar">
                        <div class="w-12 rounded">
                            <img
                                src="https://gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}"
                                alt="{{__('Avatar of',['user'=>auth()->user()->name])}}"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex-col w-full">
                    <div class="uppercase">
                        {{auth()->user()->name}}
                    </div>
                    <div class="text-sm text-gray-400">
                        {{auth()->user()->email}}
                    </div>
                </div>
                <div class="">

                        <x-mary-button
                            icon="o-arrow-right-start-on-rectangle"
                            class="btn-circle btn-outline"
                            type="submit"
                            tooltip="{{ __('Log Out') }}"
                            tooltip-bottom
                            wire:click="logout()"
                        />
                </div>
            </div>

            <div class="divider my-2">
                <x-badge-user-role/>
            </div>
            <x-mary-menu class="" activate-by-route>
                @can('access-admin-panel')
                    <x-mary-menu-item
                        title="{{__('menu.adm-panel')}}"
                        link="{{route('panel.home')}}"
                        icon="o-adjustments-horizontal"
                    />
                @endcan
            </x-mary-menu>

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.showDrawerLogin = false"/>
                {{--            <x-mary-button label="Confirm" class="btn-primary" icon="o-check" />--}}
            </x-slot:actions>
        </x-drawer>
    @endauth
</div>
