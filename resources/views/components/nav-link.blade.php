@props(['active', 'href' => '#'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white bg-gray-100 dark:bg-gray-700 group'
            : 'flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $icon ?? '' }}
    <span class="ml-3">{{ $slot }}</span>
</a>
