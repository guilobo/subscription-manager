@php use Mcamara\LaravelLocalization\Facades\LaravelLocalization; @endphp
<div>
    <x-dropdown class="z-40">
        <x-slot:trigger>
            <x-mary-button icon="o-language" class="btn-circle"/>
        </x-slot:trigger>

        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @php
                $localeMapped = LaravelLocalization::getLocaleFromMapping($localeCode);
                $urlLocalizedMapped = str_replace($localeCode,$localeMapped,LaravelLocalization::getLocalizedURL($localeCode, forceDefaultLocation:  true));
            @endphp
            <x-menu-item
                link="{{ $urlLocalizedMapped }}"
                route="{{ $urlLocalizedMapped }}"
                :active="LaravelLocalization::getCurrentLocale() == $localeCode"
                class="z-5"
                noWireNavigate
            >
                <div class="z-5">
                    <div>{{ strtoupper(str_replace('_', '-',$localeCode)) }}</div>
                    <div class="text-xs uppercase font-semibold opacity-60 z-5">{{$properties['native']}}</div>
                </div>
            </x-menu-item>
        @endforeach
    </x-dropdown>
</div>
