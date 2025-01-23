@props(['active' => false])

<a {{ $attributes->merge() }}
    class="flex flex-col items-center justify-center px-5
           {{ $active ? 'bg-gray-50 dark:bg-gray-800' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }} group">
    <!-- Icon slot -->
    <div
        class="{{ $active ? 'text-primary-600 dark:text-primary-500' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-500' }}">
        {{ $icon }}
    </div>

    <!-- Label slot -->
    <span
        class="text-sm text-center
               {{ $active ? 'text-primary-600 dark:text-primary-500' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-500' }}">
        {{ $slot }}
    </span>
</a>
