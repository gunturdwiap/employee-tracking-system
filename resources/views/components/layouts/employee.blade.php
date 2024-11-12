<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ? $title . ' - ' . config('app.name', '') : config('app.name', 'title') }}</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-gray-50 dark:bg-gray-900">

    <x-navbar></x-navbar>

    <!-- Main Content Area -->
    <section class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
        {{ $slot }}
        <!-- Add more content as needed -->
    </section>

    <!-- Bottom Navigation Bar -->
    <x-bottom-navbar></x-bottom-navbar>

    <x-toast></x-toast>

    @stack('scripts')
</body>

</html>
