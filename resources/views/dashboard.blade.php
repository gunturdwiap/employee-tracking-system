<x-layouts.admin>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
        ]" />
    </x-slot:breadcrumb>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4 ">
        <x-info-card title="Pending Vacation Requests" :body="$pendingVacationRequestCount" :link="route('vacation-requests.index', ['status[]' => 'pending'])" />
        <x-info-card title="Pending Attendance Verifications" :body="$pendingAttendanceVerificationCount" :link="route('attendances.index', ['verification_status' => 'pending'])" />

        {{-- <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-24 md:h-48"></div> --}}
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            @include('dashboard.attendance-trends-chart')
        </div>

        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            @include('dashboard.attendance-status-chart')
        </div>
    </div>


    <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4"></div>
    <div class="grid grid-cols-2 gap-4">
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
        <div class="border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 h-48 md:h-72"></div>
    </div>




</x-layouts.admin>
