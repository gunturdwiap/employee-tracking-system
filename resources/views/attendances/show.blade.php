<x-layouts.admin>
    <x-slot:title>
        Attendance Details
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
            'Attendances' => route('attendances.index'),
            'Detail' => '#',
        ]" />
    </x-slot:breadcrumb>

    <!-- Display User's Name -->
    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $attendance->user->name }}</p>
    <p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $attendance->date->format('l, Y-m-d') }}</p>

    <div class="mt-6 space-y-6">
        <!-- Status & Verification Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="font-semibold text-gray-900 dark:text-white">Verification Status:</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">
                    <x-badge :text="$attendance->status->label()" :colorMaps="[
                        'on time' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                        'late' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                        'vacation' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                        'absent' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                    ]"></x-badge>
                </dd>
            </div>

            <div>
                <dt class="font-semibold text-gray-900 dark:text-white">Status:</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">
                    <x-badge :text="$attendance->verification_status->label()" :colorMaps="[
                        'pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                    ]"></x-badge>
                </dd>
            </div>
        </div>

        <!-- Time & Photos Section (Grid layout) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Check-in Time and Photo -->
            <div class="flex flex-col space-y-4">
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Check-in Time:</dt>
                    <dd class="font-light text-gray-500 dark:text-gray-400">
                        {{ $attendance->check_in_time ? $attendance->check_in_time->format('H:i:s') : 'Not Checked In' }}
                    </dd>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Check-in Photo:</p>
                    @if ($attendance->check_in_photo)
                        <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Check-in Photo"
                            class=" w-80 h-80 object-cover rounded-lg">
                    @else
                        <p class="text-sm text-gray-500">No Check-in Photo</p>
                    @endif
                </div>
            </div>

            <!-- Check-out Time and Photo -->
            <div class="flex flex-col space-y-4">
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Check-out Time:</dt>
                    <dd class="font-light text-gray-500 dark:text-gray-400">
                        {{ $attendance->check_out_time ? $attendance->check_out_time->format('H:i:s') : 'Not Checked Out' }}
                    </dd>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">Check-out Photo:</p>
                    @if ($attendance->check_out_photo)
                        <img src="{{ asset('storage/' . $attendance->check_out_photo) }}" alt="Check-out Photo"
                            class=" w-80 h-80 object-cover rounded-lg">
                    @else
                        <p class="text-sm text-gray-500">No Check-out Photo</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Approval & Rejection Buttons -->
    <div class="flex items-center space-x-4 mt-8">
        <!-- Approval Button -->
        <form action="{{ route('attendances.verify', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="verification_status" value="approved">
            <button type="submit"
                class="gap-2 inline-flex items-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                Approve
            </button>
        </form>

        <!-- Rejection Button -->
        <form action="{{ route('attendances.verify', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="verification_status" value="rejected">
            <button type="submit"
                class="gap-2 inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
                Reject
            </button>
        </form>
    </div>

</x-layouts.admin>
