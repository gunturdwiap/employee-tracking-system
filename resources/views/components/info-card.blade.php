@props(['title', 'link' => '#', 'body', 'buttonText' => 'View Details'])

<div
    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col gap-y-2">
    <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>
    <h5 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $body }}</h5>
    <a href="{{ $link }}"
        class="justify-center mt-auto inline-flex items-center py-3 text-sm font-bold text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
        {{ $buttonText ?? 'View Details' }}
        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 5h12m0 0L9 1m4 4L9 9" />
        </svg>
    </a>
</div>
