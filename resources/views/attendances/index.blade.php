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

    <x-table>
        <x-slot:header-actions>
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <x-search-bar>
                        <input type="hidden" name="status" value="{{ request('status') }}" />
                        <input type="hidden" name="verification_status" value="{{ request('verification_status') }}" />
                        <input type="hidden" name="from" value="{{ request('from') }}" />
                        <input type="hidden" name="to" value="{{ request('to') }}" />
                    </x-search-bar>
                </div>
                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <button type="button"
                        class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Add product
                    </button>
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                            class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
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
                        <div id="filterDropdown"
                            class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose Filters</h6>
                            <form method="GET" action="{{ url()->current() }}" class="max-w-sm mx-auto gap-y-0.5">
                                <!-- Status Dropdown -->
                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-900 dark:text-gray-100">Status</label>
                                    <select id="status" name="status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option value="">Select Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <!-- Verification Status Dropdown -->
                                <div>
                                    <label for="verification_status"
                                        class="block text-sm font-medium text-gray-900 dark:text-gray-100">Verification
                                        Status</label>
                                    <select id="verification_status" name="verification_status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option value="">Select Verification Status</option>
                                        <option value="approved"
                                            {{ request('verification_status') == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="rejected"
                                            {{ request('verification_status') == 'rejected' ? 'selected' : '' }}>
                                            Rejected</option>
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
                </div>
            </div>
        </x-slot:header-actions>

        <x-slot:header>
            <tr>
                <th scope="col" class="px-4 py-3">date</th>
                <th scope="col" class="px-4 py-3">name</th>
                <th scope="col" class="px-4 py-3">check in</th>
                <th scope="col" class="px-4 py-3">check_out</th>
                <th scope="col" class="px-4 py-3">status</th>
                <th scope="col" class="px-4 py-3">verification status</th>
                <th scope="col" class="px-4 py-3">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </x-slot:header>

        <x-slot:body>
            @forelse ($attendances as $attendance)
                <tr class="border-b dark:border-gray-700">
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $attendance->date->format('Y-m-d') }}</th>
                    <td class="px-4 py-3">{{ $attendance->user->name }}</td>
                    <td class="px-4 py-3">{{ $attendance->check_in_time?->format('H:i') }}</td>
                    <td class="px-4 py-3">{{ $attendance->check_out_time?->format('H:i') }}</td>
                    <td class="px-4 py-3">{{ $attendance->status }}</td>
                    <td class="px-4 py-3">{{ $attendance->verification_status }}</td>
                    <td class="px-4 py-3">

                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <form action="{{ route('attendances.verify', ['attendance' => $attendance]) }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="verification_status" value="approved">
                                <button
                                    class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-2 focus:ring-primary-700 focus:text-primary-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-primary-500 dark:focus:text-white">
                                    <svg class="text-green-600 dark:text-green-500 w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            </form>
                            <form action="{{ route('attendances.verify', ['attendance' => $attendance]) }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="verification_status" value="rejected">
                                <button
                                    class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-2 focus:ring-primary-700 focus:text-primary-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-primary-500 dark:focus:text-white">
                                    <svg class="text-red-600 dark:text-red-500 w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            </form>
                            <a href="{{ route('attendances.show', ['attendance' => $attendance]) }}" type="button"
                                class="p-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-2 focus:ring-primary-700 focus:text-primary-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-primary-500 dark:focus:text-white">
                                <svg class="text-white-600 dark:text-white-500 w-6 h-6"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                        </div>


                    </td>
                </tr>
            @empty
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-3 text-center" colspan="7">
                        Not Found
                    </td>
                </tr>
            @endforelse
        </x-slot:body>

        <x-slot:pagination>
            {{ $attendances->onEachSide(3)->links() }}
        </x-slot:pagination>
    </x-table>



</x-layouts.admin>
