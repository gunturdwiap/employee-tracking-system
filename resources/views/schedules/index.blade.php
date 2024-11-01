<x-layouts.app>
    <x-slot:title>
        Schedules
    </x-slot:title>
    <div>
        <table class="border">
            <thead>
                <tr>
                    <th>day</th>
                    <th>name</th>
                    <th>start</th>
                    <th>end</th>
                    <th>lat long</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr class="">
                        <td>
                            {{ $schedule->day }}
                        </td>
                        <td>
                            {{ $schedule->user->name }}
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
                        <td>
                            <a href="{{ route('users.show', ['user' => $schedule->user]) }}">show</a>
                            {{-- <a href="{{ route('schedules.destroy', ['schedule' => $schedule]) }}">delete</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>
