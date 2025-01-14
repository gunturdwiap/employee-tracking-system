@props(['text', 'colorMaps' => []])

@php
    $badgeClass = $colorMaps[strtolower($text)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
@endphp

<span {{ $attributes->merge(['class' => "$badgeClass text-xs font-medium me-2 px-2.5 py-0.5 rounded"]) }}>
    {{ $text }}
</span>
