<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-theme="dark"
      class="dark"
>
<head>
    @include('partials.head')
    <x-head-alternate-lang/>
    <style>
        .nav-transparent {
            background: linear-gradient(180deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
            transition: background-color 0.3s ease;
        }

        .dark .nav-solid {
            background-color: rgb(20, 20, 20);
        }

        .light .nav-solid,
        html:not(.dark) .nav-solid {
            background-color: rgb(255, 255, 255);
        }

        .hero-section {
            min-height: 100vh;
            width: 100%;
        }
    </style>
</head>

<body class="font-sans antialiased bg-base-100"
      x-data="{
          scrolled: false,
          init() {
              window.addEventListener('scroll', () => {
                  this.scrolled = window.scrollY > 50
              })
          }
      }">

<nav :class="scrolled ? 'nav-solid' : 'nav-transparent'"
     class="fixed top-0 left-0 right-0 z-[99]">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- Brand/Logo --}}
            <div class="w-32 lg:w-40">
                <a href="{{route('home')}}">
                    <x-logo-dark-light/>
                </a>
            </div>

            {{-- Right side actions --}}
            <div class="flex items-center gap-2 lg:gap-4">
                <x-theme-toggle class="btn-ghost btn-sm"/>
                <livewire:helpers.lang-changer wire:key="lang-changer"/>
                <livewire:helpers.login-drop-down wire:key="login-drop-down"/>
            </div>
        </div>
    </div>
</nav>

{{-- Hero/Featured Section Slot (100vh) --}}
@if(isset($hero))
    <section class="hero-section relative bg-base-200">
        {{ $hero }}
    </section>
@endif


{{-- Main Content Section --}}
<main class="relative bg-base-100 @if(!isset($hero)) pt-20 lg:pt-24 @endif">
    <div class="container mx-auto px-4 lg:px-8 py-8">
        {{ $slot }}
    </div>
</main>

</body>
</html>
