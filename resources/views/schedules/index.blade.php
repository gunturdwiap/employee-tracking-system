<x-layouts.admin>
    <x-slot:title>
        Schedules
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
            'Schedules' => '#',
        ]" />
    </x-slot:breadcrumb>

    @include('schedules.partials.schedule-table', [
        'employees' => $employees,
    ])

</x-layouts.admin>
