@php use Mcamara\LaravelLocalization\Facades\LaravelLocalization; @endphp
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    @php
        $localeMapped = LaravelLocalization::getLocaleFromMapping($localeCode);
        $urlLocalizedMapped = str_replace($localeCode,$localeMapped,LaravelLocalization::getLocalizedURL($localeCode, forceDefaultLocation:  true));
    @endphp
    <link rel="alternate" hreflang="{{ str_replace('_', '-',$localeCode) }}"
          href="{{$urlLocalizedMapped }}">
@endforeach
