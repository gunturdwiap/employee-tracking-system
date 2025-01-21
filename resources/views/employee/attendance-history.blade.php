<x-layouts.employee>
    <x-slot:title>
        Attendance History
    </x-slot:title>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2 mx-auto mt-4">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Attendance History</h5>
        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

        <x-table>
            <x-slot:header-actions>
                <div class="p-4">
                    <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                        class="w-full flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400"
                            viewbox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filter
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose Filters</h6>
                        <form method="GET" action="{{ url()->current() }}" class="max-w-sm mx-auto gap-y-0.5">
                            <!-- Status Dropdown -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-900 dark:text-gray-100">Status</label>
                                <select id="status" name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="" disabled>Select Status</option>
                                    @foreach (App\Enums\AttendanceStatus::cases() as $status)
                                        <option value="{{ $status->value }}"
                                            {{ request('status') == $status->value ? 'selected' : '' }}>
                                            {{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Verification Status Dropdown -->
                            <div>
                                <label for="verification_status"
                                    class="block text-sm font-medium text-gray-900 dark:text-gray-100">Verification
                                    Status</label>
                                <select id="verification_status" name="verification_status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="" disabled>Select Verification Status</option>
                                    @foreach (App\Enums\AttendanceVerificationStatus::cases() as $day)
                                        <option value="{{ $day->value }}"
                                            {{ request('verification_status') == $day->value ? 'selected' : '' }}>
                                            {{ $day->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date From Input -->
                            <div>
                                <label for="from"
                                    class="block text-sm font-medium text-gray-900 dark:text-gray-100">
                                    From</label>
                                <input type="date" id="from" name="from" value="{{ request('from') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>

                            <!-- Date To Input -->
                            <div>
                                <label for="to"
                                    class="block text-sm font-medium text-gray-900 dark:text-gray-100">
                                    To</label>
                                <input type="date" id="to" name="to" value="{{ request('to') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>

                            <input type="hidden" name="s" value="{{ request('s') }}" />

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full py-2 mt-2 text-sm font-medium text-white  bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-700 rounded-lg">
                                Apply
                            </button>
                        </form>

                    </div>
                </div>
            </x-slot:header-actions>

            <x-slot:header>
                <tr>
                    <th scope="col" class="px-4 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Start
                    </th>
                    <th scope="col" class="px-4 py-3">
                        End
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Verification Status
                    </th>
                </tr>
            </x-slot:header>

            <x-slot:body>
                @forelse ($attendances as $attendance)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $attendance->date->format('l, Y-m-d') }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $attendance->check_in_time?->format('H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $attendance->check_out_time?->format('H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <x-badge :text="$attendance->status->label()" :colorMaps="[
                                'on time' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                'late' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                'vacation' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                'absent' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                            ]"></x-badge>
                        </td>
                        <td class="px-6 py-4">
                            <x-badge :text="$attendance->verification_status->label()" :colorMaps="[
                                'pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                            ]"></x-badge>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            No data
                        </th>
                    </tr>
                @endforelse
            </x-slot:body>

            <x-slot:pagination>
                {{ $attendances->onEachSide(3)->links() }}
            </x-slot:pagination>

        </x-table>

    </div>

</x-layouts.employee>
