<x-layouts.admin>
    <x-slot:title>
        Vacation Requests
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
            'Vacation Requests' => '#',
        ]" />
    </x-slot:breadcrumb>

    @include('vacation-request.partials.vacation-request-table', [
        'vacationRequests' => $vacationRequests,
    ])

</x-layouts.admin>
