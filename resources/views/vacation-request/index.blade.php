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

    <x-table>

        <x-slot:header-actions>
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <x-search-bar>
                        @foreach (request('status', []) as $status)
                            <input type="hidden" name="status[]" value="{{ $status }}" />
                        @endforeach
                    </x-search-bar>
                </div>
                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
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
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Select Status</h6>
                            <form method="GET" action="{{ url()->current() }}">
                                <ul class="space-y-2 text-sm">
                                    @foreach (App\Enums\VacationRequestStatus::cases() as $status)
                                        <li class="flex items-center">
                                            <input id="{{ $status->label() }}" type="checkbox"
                                                value="{{ $status->value }}" name="status[]"
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                {{ in_array($status->value, request('status', [])) ? 'checked' : '' }}>
                                            <label for="{{ $status->label() }}"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $status->label() }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                                <input type="hidden" name="s" value="{{ request('s') }}" />

                                <button onclick="resetForm(this)" type="button"
                                    class="w-full py-2 mt-2 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Reset</button>

                                <button type="submit"
                                    class="w-full py-2 mt-2 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot:header-actions>

        <x-slot:header>
            <tr>
                <th scope="col" class="px-4 py-3">Name</th>
                <th scope="col" class="px-4 py-3">Start</th>
                <th scope="col" class="px-4 py-3">End</th>
                <th scope="col" class="px-4 py-3">Reason</th>
                <th scope="col" class="px-4 py-3">Status</th>
                <th scope="col" class="px-4 py-3">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </x-slot:header>

        <x-slot:body>
            @forelse ($vacationRequests as $vacationRequest)
                <tr class="border-b dark:border-gray-700">
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $vacationRequest->user->name }}</th>
                    <td class="px-4 py-3">{{ $vacationRequest->start->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">{{ $vacationRequest->end->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">{{ Str::limit($vacationRequest->reason, 50, '...') }}</td>
                    <td class="px-4 py-3">
                        <x-badge :text="$vacationRequest->status->label()" :colorMaps="[
                            'pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                        ]"></x-badge>
                    </td>
                    <td class="px-4 py-3">

                        <button id="{{ $vacationRequest->id }}-dropdown-button"
                            data-dropdown-toggle="{{ $vacationRequest->id }}-dropdown"
                            class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                            type="button">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                        <div id="{{ $vacationRequest->id }}-dropdown"
                            class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="{{ $vacationRequest->id }}-dropdown-button">
                                <li>
                                    <form
                                        action="{{ route('vacation-requests.update-status', ['vacation_request' => $vacationRequest->id]) }}"
                                        method="post" class="">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit"
                                            class="hover:text-green-600 dark:hover:text-green-500 flex justify-start items-center gap-2 w-full py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
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
                                        action="{{ route('vacation-requests.update-status', ['vacation_request' => $vacationRequest->id]) }}"
                                        method="post" class="">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit"
                                            class="hover:text-red-600 dark:hover:text-red-500 flex justify-start items-center gap-2 w-full py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
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
                                <button data-vacation-request-id="{{ $vacationRequest->id }}"
                                    class="hover:text-primary-600 dark:hover:text-primary-500 flex justify-start items-center gap-2 w-full py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                    <svg class="text-white-600 dark:text-white-500 w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Show
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="border-b dark:border-gray-700">
                    <td colspan="6" class="px-4 py-3 text-center">
                        Not Found
                    </td>
                </tr>
            @endforelse
        </x-slot:body>

        <x-slot:pagination>
            {{ $vacationRequests->withQueryString()->onEachSide(3)->links() }}
        </x-slot:pagination>

    </x-table>

    @push('scripts')
        <script type="module">
            const url = '{{ url()->current() }}';
            console.log(url);

            function modalTemplate(vacationRequest) {
                return `
                    <div class="flex justify-start mb-4 rounded-t sm:mb-5">
                        <div class="text-xl text-gray-900 md:text-xl dark:text-white">
                            <h3 class="font-semibold ">
                                ${vacationRequest.user.name}
                            </h3>
                        </div>
                    </div>
                    <dl class="text-start">
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Start</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">${vacationRequest.start}</dd>
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">End</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">${vacationRequest.end}</dd>
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Reason</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">${vacationRequest.reason}</dd>
                    </dl>
                `;
            }

            async function fetchData(id) {
                swalLoading();
                try {
                    const response = await fetch(`${url}/${id}`);

                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }

                    const json = await response.json();
                    swalModal('Vacation Request Detail', modalTemplate(json.data));
                } catch (error) {
                    console.log(error);
                    swalError('Error fetching data');
                }
            }

            document.querySelectorAll('button[data-vacation-request-id]').forEach(button => {
                button.addEventListener('click', function(e) {
                    const vacationRequestId = e.target.getAttribute('data-vacation-request-id');
                    fetchData(vacationRequestId);
                });
            });
        </script>
    @endpush
</x-layouts.admin>
