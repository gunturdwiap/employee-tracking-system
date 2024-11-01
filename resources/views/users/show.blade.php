<x-layouts.app>
    <x-slot:title>
        User Detail
    </x-slot:title>
    <div>
        <div>
            <ul>
                <li>name : {{ $user->name }}</li>
                <li>role : {{ $user->role }}</li>
                <li>email : {{ $user->email }}</li>
            </ul>
        </div>
        schedules
        <a href="{{ route('schedules.create', ['user' => $user]) }}">create schedule</a>
        <table class="border">
            <thead>
                <tr>
                    <th>day</th>
                    <th>start</th>
                    <th>end</th>
                    <th>lat, long</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->schedules as $schedule)
                    <tr class="">
                        <td class="">
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
                        <td>
                            <a href="{{ route('schedules.edit', ['user' => $user, 'schedule' => $schedule]) }}">edit</a>
                            <form action="{{ route('schedules.destroy', ['user' => $user, 'schedule' => $schedule]) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button onclick="confirm('ykin km?')">delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>
