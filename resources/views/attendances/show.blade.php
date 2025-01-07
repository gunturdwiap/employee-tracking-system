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
    <p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $attendance->date->format('Y-m-d') }}</p>

    <div class="mt-6 space-y-6">
        <!-- Status & Verification Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="font-semibold text-gray-900 dark:text-white">Verification Status:</dt>
                <dd
                    class="font-light text-gray-500 dark:text-gray-400
                    {{ $attendance->verification_status->value == 'approved'
                        ? 'text-green-500'
                        : ($attendance->verification_status->value == 'rejected'
                            ? 'text-red-500'
                            : 'text-yellow-500') }}">
                    {{ $attendance->verification_status->label() }}
                </dd>
            </div>

            <div>
                <dt class="font-semibold text-gray-900 dark:text-white">Status:</dt>
                <dd
                    class="font-light text-gray-500 dark:text-gray-400
                    {{ $attendance->status->value == 'on_time'
                        ? 'text-green-500'
                        : ($attendance->status->value == 'late'
                            ? 'text-yellow-500'
                            : 'text-gray-500') }}">
                    {{ $attendance->verification_status->label() }}
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
                class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
                <svg aria-hidden="true" class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                    <path fill-rule="evenodd"
                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                        clip-rule="evenodd"></path>
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
                class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                <svg aria-hidden="true" class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Reject
            </button>
        </form>
    </div>

</x-layouts.admin>
