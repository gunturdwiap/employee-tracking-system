<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ? $title . ' - ' . config('app.name', '') : config('app.name', 'title') }}</title>

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

<body>
    <div class="antialiased bg-gray-50 dark:bg-gray-900 min-h-screen">

        <x-navbar></x-navbar>

        <x-sidebar></x-sidebar>

        <main class="p-4 md:ml-64 h-auto pt-20">
            <section class="bg-gray-50 dark:bg-gray-900 p-1 sm:p-3">
                <div class="mx-auto max-w-screen-xl px-1 lg:px-4">

                    {{ $breadcrumb }}

                    <h2
                        class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl dark:text-white">
                        {{ $title }}
                    </h2>

                    {{ $slot }}

                </div>
            </section>
        </main>
        <x-alert></x-alert>
        @stack('scripts')

    </div>
</body>

</html>
