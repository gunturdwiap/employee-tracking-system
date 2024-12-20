<div class="flex justify-between items-start w-full">
    <div class="flex-col items-center">
        <div class="flex items-center mb-1">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">Attendance Overview
            </h5>
        </div>
        <button id="dateRangeButton" data-dropdown-toggle="dateRangeDropdown"
            data-dropdown-ignore-click-outside-class="datepicker" type="button"
            class="inline-flex items-center text-blue-700 dark:text-blue-600 font-medium hover:underline">
            <span id="dateRangeText"></span>
            <svg class="w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
        </button>
        <div id="dateRangeDropdown"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-80 lg:w-96 dark:bg-gray-700 dark:divide-gray-600">
            <div class="p-3" aria-labelledby="dateRangeButton">
                <div class="flex items-center">
                    <div class="relative">
                        <x-forms.input name="from" type="date" />
                    </div>
                    <span class="mx-2 text-gray-500 dark:text-gray-400">to</span>
                    <div class="relative">
                        <x-forms.input name="to" type="date" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="flex justify-end items-center">
            <button id="widgetDropdownButton" data-dropdown-toggle="widgetDropdown" data-dropdown-placement="bottom"
                type="button"
                class="inline-flex items-center justify-center text-gray-500 w-8 h-8 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm"><svg
                    class="w-3.5 h-3.5 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                    <path
                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                </svg><span class="sr-only">Open dropdown</span>
            </button>
            <div id="widgetDropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="widgetDropdownButton">
                    <li>
                        <a href="#"
                            class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg
                                class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 21 21">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                            </svg>Edit widget
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg
                                class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                                <path
                                    d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                            </svg>Download data
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg
                                class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m5.953 7.467 6.094-2.612m.096 8.114L5.857 9.676m.305-1.192a2.581 2.581 0 1 1-5.162 0 2.581 2.581 0 0 1 5.162 0ZM17 3.84a2.581 2.581 0 1 1-5.162 0 2.581 2.581 0 0 1 5.162 0Zm0 10.322a2.581 2.581 0 1 1-5.162 0 2.581 2.581 0 0 1 5.162 0Z" />
                            </svg>Add to repository
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg
                                class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 18 20">
                                <path
                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                            </svg>Delete widget
                        </a>
                    </li>
                </ul>
            </div>
        </div> --}}
</div>

<!-- Line Chart -->
<div class="py-6" id="pie-chart"></div>

{{-- <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
        <div class="flex justify-between items-center pt-5">
            <!-- Button -->
            <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown"
                data-dropdown-placement="bottom"
                class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                type="button">
                Last 7 days
                <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="lastDaysdropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                            7 days</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                            30 days</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                            90 days</a>
                    </li>
                </ul>
            </div>
            <a href="#"
                class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                Traffic analysis
                <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
            </a>
        </div>
    </div> --}}


@push('scripts')
    <script type="module">
        const url = "{{ route('attendances.overview') }}";

        function getOptions() {
            return {
                series: [],
                colors: ["#1C64F2", "#16BDCA", "#9061F9", "#F97316"],
                chart: {
                    height: "100%",
                    width: "100%",
                    type: "pie",
                },
                stroke: {
                    colors: ["white"],
                    lineCap: "",
                },
                plotOptions: {
                    pie: {
                        labels: {
                            show: true,
                        },
                        size: "100%",
                        dataLabels: {
                            offset: -25
                        }
                    },
                },
                labels: [],
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                xaxis: {
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
            }
        }

        async function fetchData(url, from = null, to = null) {
            try {
                let fullUrl = (from === null) && (to === null) ? url : `${url}?from=${from}&to=${to}`;

                const response = await fetch(fullUrl);
                const json = await response.json();

                let labels = [...new Set(json.data.map((data) => data.status))]
                let series = json.data.map((data) => data.count)
                console.log(labels);
                console.log(series);

                return {
                    labels,
                    series
                };
            } catch (error) {
                console.error(error.message);
                return null;
            }
        }

        function updateChart(chart, data) {
            if (data) {
                chart.updateOptions({
                    labels: data.labels,
                    series: data.series
                });
            } else {
                console.error("Failed to update chart");
            }
        }

        function formatDate(date) {
            const d = new Date(date);
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function changeDateRangeText(start, end) {
            const dateRangeText = document.getElementById('dateRangeText');
            dateRangeText.textContent = `${start} - ${end}`;
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const chart = new ApexCharts(document.getElementById("pie-chart"), getOptions());
            chart.render();

            // fetch data from 1 month ago to today
            const today = formatDate(new Date())
            const thirtyDaysAgo = formatDate(new Date(Date.now() - 30 * 24 * 60 * 60 * 1000));
            const data = await fetchData(url, thirtyDaysAgo, today);
            updateChart(chart, data);
            changeDateRangeText(thirtyDaysAgo, today);

            // handle date change
            const dateFrom = document.querySelector('input[name="from"]');
            const dateTo = document.querySelector('input[name="to"]');
            async function handleDateChange() {
                const from = dateFrom.value;
                const to = dateTo.value;
                if (from && to) {
                    const data = await fetchData(url, from, to);
                    console.log(data);
                    updateChart(chart, data);
                    changeDateRangeText(from, to);
                }
            }

            dateFrom.addEventListener('change', handleDateChange);
            dateTo.addEventListener('change', handleDateChange);
        });
    </script>
@endpush
