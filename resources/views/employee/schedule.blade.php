<x-layouts.employee>
    <x-slot:title>
        Schedule
    </x-slot:title>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Hallo bang {{ auth()->user()->name }}</h5>
        <p class=" text-lg font-medium text-gray-900 dark:text-white">
            Jadwal km:
        </p>
        <table class="border">
            <thead>
                <tr>
                    <th>day</th>
                    <th>start</th>
                    <th>end</th>
                    <th>lat long</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                    <tr class="">
                        <td>
                            {{ $schedule->day }}
                        </td>
                        <td>
                            {{ $schedule->work_start_time->format('H:i') }}
                        </td>
                        <td>
                            {{ $schedule->work_end_time->format('H:i') }}
                        </td>
                        <td>
                            {{ $schedule->latitude }}, {{ $schedule->longitude }}
                        </td>

                    </tr>

                @empty
                    <p class=" text-lg font-medium text-gray-900 dark:text-white">
                        Nggak ada jadwal coy
                    </p>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.employee>
