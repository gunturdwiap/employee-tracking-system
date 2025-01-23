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


    <div class="rounded-lg mb-4">
        <x-table>
            <x-slot:header-actions>
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Today's Attendances
                        </h2>
                    </div>
                    <div class="w-full md:w-1/2">
                        <x-search-bar>

                        </x-search-bar>
                    </div>
                </div>
            </x-slot:header-actions>

            <x-slot:header>
                <tr>
                    <th scope="col" class="px-4 py-3">name</th>
                    <th scope="col" class="px-4 py-3">check in</th>
                    <th scope="col" class="px-4 py-3">check out</th>
                    <th scope="col" class="px-4 py-3">status</th>
                    <th scope="col" class="px-4 py-3">verification status</th>
                    <th scope="col" class="px-4 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </x-slot:header>

            <x-slot:body>
                @forelse ($todaysAttendances as $todaysAttendance)
                    <tr class="border-b dark:border-gray-700">

                        <th
                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white max-w-24 text-wrap">
                            {{ $todaysAttendance->user->name }}</th>
                        <td class="px-4 py-3 font-bold">
                            {{ $todaysAttendance->check_in_time?->format('H:i') }}
                            @if ($todaysAttendance->check_in_photo)
                                <img src="{{ asset('storage/' . $todaysAttendance->check_in_photo) }}"
                                    class="w-16 md:w-32 max-w-full max-h-full rounded-lg">
                            @else
                                <p class="text-sm font-normal">No Check-in Photo</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-bold">
                            {{ $todaysAttendance->check_out_time?->format('H:i') }}
                            @if ($todaysAttendance->check_out_photo)
                                <img src="{{ asset('storage/' . $todaysAttendance->check_out_photo) }}"
                                    class="w-16 md:w-32 max-w-full max-h-full rounded-lg">
                            @else
                                <p class="text-sm font-normal">No Check-out Photo</p>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <x-badge :text="$todaysAttendance->status->label()" :colorMaps="[
                                'on time' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                'late' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                'vacation' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                'absent' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                            ]"></x-badge>
                        </td>
                        <td class="px-4 py-3">
                            <x-badge :text="$todaysAttendance->verification_status->label()" :colorMaps="[
                                'pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                            ]"></x-badge>
                        </td>
                        <td class="px-4 py-3">
                            <button id="{{ $todaysAttendance->id }}-dropdown-button"
                                data-dropdown-toggle="{{ $todaysAttendance->id }}-dropdown"
                                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                type="button">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                            <div id="{{ $todaysAttendance->id }}-dropdown"
                                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="{{ $todaysAttendance->id }}-dropdown-button">
                                    <li>
                                        <form
                                            action="{{ route('attendances.verify', ['attendance' => $todaysAttendance]) }}"
                                            method="post" class="">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="verification_status" value="approved">
                                            <button type="submit"
                                                class="hover:text-green-600 dark:hover:text-green-500 flex justify-start gap-2 items-center w-full py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m4.5 12.75 6 6 9-13.5" />
                                                </svg>
                                                Approve
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form
                                            action="{{ route('attendances.verify', ['attendance' => $todaysAttendance]) }}"
                                            method="post" class="">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="verification_status" value="rejected">
                                            <button type="submit"
                                                class="hover:text-red-600 dark:hover:text-red-500 flex justify-start gap-2 items-center w-full py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                                Reject
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                                <div>
                                    <a href="{{ route('attendances.show', ['attendance' => $todaysAttendance->id]) }}"
                                        class="hover:text-primary-600 dark:hover:text-primary-500 flex justify-start gap-2 items-center w-full py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                        <svg class="text-white-600 dark:text-white-500 w-6 h-6"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Show
                                    </a>
                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-3 text-center" colspan="6">
                            Not Found
                        </td>
                    </tr>
                @endforelse
            </x-slot:body>

            <x-slot:pagination>
                {{ $todaysAttendances->withQueryString()->onEachSide(3)->links() }}
            </x-slot:pagination>
        </x-table>
    </div>


    @push('scripts')
        <script>
            // Save scroll position before refresh
            window.addEventListener('beforeunload', function() {
                if (sessionStorage.getItem('scrollPosition')) {
                    sessionStorage.removeItem('scrollPosition');
                } else {
                    sessionStorage.setItem('scrollPosition', window.scrollY);
                }
            });

            // Restore scroll position after page load
            window.addEventListener('load', function() {
                const scrollPosition = sessionStorage.getItem('scrollPosition');
                if (scrollPosition) {
                    setTimeout(() => {
                        window.scrollTo({
                            top: parseInt(scrollPosition, 10),
                            behavior: 'smooth' // Smooth scroll
                        });
                    }, 75); // Delay for smoother experience
                }
            });
        </script>
    @endpush

</x-layouts.admin>
