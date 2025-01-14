@props(['active', 'href' => '#'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center p-2 text-base font-medium rounded-lg bg-gray-100 dark:bg-gray-700 group text-primary-600 dark:text-primary-500'
            : 'flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-500 group';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $icon ?? '' }}
    <span class="ml-3">{{ $slot }}</span>
</a>
