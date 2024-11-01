<x-layouts.app>
    <x-slot:title>
        Users
    </x-slot:title>
    <div>
        <table class="border">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>role</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="">
                        <td>
                            {{ $user->id }}
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $user->role }}
                        </td>
                        <td>
                            <a href="{{ route('users.show', ['user' => $user]) }}">show</a>
                            {{-- <a href="{{ route('users.destroy', ['user' => $user]) }}">delete</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>
