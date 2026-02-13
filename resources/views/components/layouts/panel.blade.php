<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-theme="dark"
      class="dark"
>
<head>
    @include('partials.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    {{-- Cropper.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />

    <x-head-alternate-lang/>
</head>

<body class="font-sans antialiased">

{{-- The navbar with `sticky` and `full-width` --}}
<x-nav full-width sticky=0 class="!z-50 !h-[65px]">
    <x-slot:brand class="">
        {{--Drawer toggle for "main-drawer"--}}
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer"/>
        </label>

        {{-- Brand --}}
        <div class="w-40">
            <a href="{{route('home')}}" >
                <x-logo-dark-light />
            </a>
        </div>
    </x-slot:brand>

    {{-- Right side actions --}}
    <x-slot:actions class="z-50">
        {{--        <x-mary-button label="Messages" icon="o-envelope" link="###" class="btn-ghost btn-sm" responsive/>--}}
        <x-theme-toggle class="btn-ghost btn-sm"/>
        {{--        <x-mary-button label="Notifications" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>--}}

        <livewire:helpers.lang-changer class="z-40"/>
        <livewire:helpers.login-drop-down/>

    </x-slot:actions>
</x-nav>

@php
    if (!session()->has('mary-sidebar-collapsed')) {
        session()->put('mary-sidebar-collapsed', 'true');
    }
@endphp
{{-- The main content with `full-width` --}}
<x-main full-width with-nav>

    {{-- This is a sidebar that works also as a drawer on small screens --}}
    {{-- Notice the `main-drawer` reference here --}}
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200 z-20">
        <div class="flex flex-col justify-between h-full">
            <!-- top elements -->
            <div class="flex space-x-4">
                <x-menu activate-by-route>
                    <x-menu-item :title="__('menu.adm-panel')" icon="o-home" link="{{route('panel.home')}}" route="panel.home" />
                </x-menu>
            </div>

            <!-- button elements -->
            <div class="flex space-x-4">
                <x-menu activate-by-route>
                    <x-menu-item :title="__('menu.adm-panel')" icon="o-cog-6-tooth" link="{{route('panel.home')}}" route="panel.home" />
                </x-menu>
            </div>
        </div>


    </x-slot:sidebar>

    {{-- The `$slot` goes here --}}
    <x-slot:content class="z-20">
        {{ $slot }}
    </x-slot:content>
</x-main>

<livewire:helpers.toast/>

</body>
</html>
