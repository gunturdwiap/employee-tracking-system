<x-layouts.employee>
    <x-slot:title>
        Schedule
    </x-slot:title>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2">
        <p class=" text-lg font-medium text-gray-900 dark:text-white">
            Schedule
        </p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Day
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Start
                        </th>
                        <th scope="col" class="px-6 py-3">
                            End
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $schedule->day->label() }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $schedule->work_start_time->format('H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $schedule->work_end_time->format('H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                No data
                            </th>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

</x-layouts.employee>
