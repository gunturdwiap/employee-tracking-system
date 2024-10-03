<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ? $title . ' - ' . config('app.name', '') : config('app.name', 'title') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">

        <x-toast></x-toast>

        <x-navbar></x-navbar>

        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <main class="p-4 md:ml-64 h-auto pt-20">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>

</html>
