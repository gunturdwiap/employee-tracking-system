<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg min-h-96">
    {{ $headerActions }}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                {{ $header }}
            </thead>
            <tbody>
                {{ $body }}
            </tbody>
        </table>
    </div>

    {{ $pagination }}

</div>
