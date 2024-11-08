<x-layouts.admin>
    <x-slot:title>
        Users
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
            'Users' => '#',
        ]" />
    </x-slot:breadcrumb>

    @include('users.partials.user-table', [
        'users' => $users,
    ])

</x-layouts.admin>
