<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ? $title . ' - ' . config('app.name', '') : config('app.name', 'title') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{ $slot }}
    <x-toast></x-toast>
</body>

</html>
