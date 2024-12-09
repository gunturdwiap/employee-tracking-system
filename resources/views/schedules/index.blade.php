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

    <x-table>
        <x-slot:header-actions>
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <x-search-bar></x-search-bar>
                </div>
            </div>
        </x-slot:header-actions>

        <x-slot:header>
            <tr>
                <th scope="col" class="px-4 py-3">Name</th>
                @foreach (App\Enums\Day::options() as $day)
                    <th scope="col" class="px-4 py-3">{{ $day['label'] }}</th>
                @endforeach
            </tr>
        </x-slot:header>

        <x-slot:body>
            @forelse ($employees as $employee)
                <tr class="border-b dark:border-gray-700">
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $employee->name }}</th>
                    @foreach (App\Enums\Day::cases() as $day)
                        <td class="px-4 py-3">
                            @php
                                $schedule = $employee->schedules->firstWhere('day', $day);
                            @endphp

                            @if ($schedule)
                                {{ $schedule->work_start_time->format('H:i') }} -
                                {{ $schedule->work_end_time->format('H:i') }}
                                <div>

                                    <div class="inline-flex rounded-md shadow-sm" role="group">
                                        <a href="{{ route('schedules.edit', ['schedule' => $schedule, 'user' => $employee]) }}"
                                            class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                            <svg class="text-yellow-400 dark:text-yellow-300 w-4 h-4"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <form onsubmit="return confirm('ykin?')"
                                            action="{{ route('schedules.destroy', ['schedule' => $schedule, 'user' => $employee]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                                <svg class="text-red-600 dark:text-red-500 w-4 h-4"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>


                                </div>
                            @else
                                <a href="{{ route('schedules.create', ['user' => $employee, 'day' => $day]) }}"
                                    class="inline-flex
                                items-center p-2 text-sm font-medium text-gray-900 bg-white border
                                border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10
                                focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800
                                dark:border-gray-700 dark:text-white dark:hover:text-white
                                dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">

                                    <svg class="text-green-600 dark:text-green-500 w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>

                                </a>
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                          </svg> --}}

                                {{-- <a href="{{ route('schedules.add', ['user' => $employee, 'day' => $day]) }}"
                                class="btn btn-success btn-sm">Add</a> --}} {{ $schedule }}
                            @endif
                        </td>
                    @endforeach

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
            {{ $employees->onEachSide(1)->links() }}
        </x-slot:pagination>
    </x-table>

</x-layouts.admin>
