<!-- components/breadcrumb.blade.php -->
<nav class="flex mb-2" aria-label="Breadcrumb"> <!-- Adjusted bottom margin for compactness -->
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        @foreach ($links as $label => $url)
            <li class="inline-flex items-center">
                @if (!$loop->last)
                    <a href="{{ $url }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                        @if ($loop->first)
                            <!-- Home Icon (only on the first item) -->
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        @endif
                        {{ $label }}
                    </a>
                @else
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</span>
                @endif
            </li>

            @if (!$loop->last)
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1 rtl:rotate-180 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>


                        {{-- <svg class="w-2.5 h-2.5 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg> --}}
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
