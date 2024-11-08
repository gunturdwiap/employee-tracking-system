<x-layouts.admin>
    <x-slot:title>
        Attendances
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
            'Attendances' => '#',
        ]" />
    </x-slot:breadcrumb>

    @include('attendances.partials.attendance-table', [
        'attendances' => $attendances,
    ])

</x-layouts.admin>
