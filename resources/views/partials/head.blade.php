<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="{{\App\Enums\DefaultImages::FAV_ICON}}" sizes="any">
<link rel="icon" href="{{\App\Enums\DefaultImages::FAV_ICON}}" type="image/svg+xml">
<link rel="apple-touch-icon" href="{{\App\Enums\DefaultImages::FAV_ICON}}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
<meta name="csrf-token" content="{{ csrf_token() }}">

