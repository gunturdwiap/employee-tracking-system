<div class="flex justify-between mb-5">
    <div class="grid gap-4 grid-cols-1">
        <div>
            <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Attendance trends</p>
        </div>
    </div>
    <div>
        <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown" data-dropdown-placement="bottom"
            type="button"
            class="px-3 py-2 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
            <span id="dropdownFilterText">Last 7 days</span>
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg></button>
        <div id="lastDaysdropdown"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <p data-last-days="7"
                        class="cursor-pointer block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Last
                        7 days</p>
                </li>
                <li>
                    <p data-last-days="30"
                        class="cursor-pointer block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Last
                        30 days</p>
                </li>
                <li>
                    <p data-last-days="90"
                        class="cursor-pointer block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Last
                        90 days</p>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="line-chart"></div>
{{-- <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between mt-2.5">
        <div class="pt-5">
            <a href="#"
                class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-3.5 h-3.5 text-white me-2 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                    <path
                        d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2Zm-3 15H4.828a1 1 0 0 1 0-2h6.238a1 1 0 0 1 0 2Zm0-4H4.828a1 1 0 0 1 0-2h6.238a1 1 0 1 1 0 2Z" />
                    <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                </svg>
                View full report
            </a>
        </div>
    </div> --}}

@push('scripts')
    <script type="module">
        const url = "{{ route('attendances.trends') }}";

        function getOptions() {
            return {
                chart: {
                    zoom: {
                        enabled: false,
                    },
                    height: 300,
                    maxWidth: "100%",
                    type: "line",
                    fontFamily: "Inter, sans-serif",
                    dropShadow: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                tooltip: {
                    enabled: true,
                    x: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -26
                    },
                },
                series: [],
                legend: {
                    show: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: [],
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        }
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: false,
                },
            }
        }

        async function fetchData(url, filter = null) {
            try {
                let fullUrl = filter === null ? url : `${url}?last_days=${filter}`;

                const response = await fetch(fullUrl);
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();

                let categories = [...new Set(json.data.map((data) => data.date))]
                let series = [{
                        name: 'On time',
                        data: json.data.map((data) => data.on_time),
                        color: "#1A56DB",
                    },
                    {
                        name: 'Late',
                        data: json.data.map((data) => data.late),
                        color: "#7E3AF2",
                    }
                ]

                return {
                    categories,
                    series
                };
            } catch (error) {
                console.error(error.message);
                return null; // Return null or some default value
            }
        }

        function updateChart(chart, data) {
            if (data) {
                console.log(data);
                chart.updateOptions({
                    xaxis: {
                        categories: data.categories
                    },
                    series: data.series
                });
            } else {
                console.error("Failed to update chart due to data fetch error.");
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const chart = new ApexCharts(document.getElementById("line-chart"), getOptions());
            // const dropdownFilterText = document.getElementById('dropdownFilterText');
            chart.render();

            const data = await fetchData(url);
            updateChart(chart, data);

            document.querySelectorAll('[data-last-days]').forEach((element) => {
                element.addEventListener('click', async function() {
                    const lastDays = this.getAttribute('data-last-days');
                    const data = await fetchData(url, lastDays);
                    updateChart(chart, data);
                    document.getElementById('dropdownFilterText').innerText =
                        `Last ${lastDays} days`;
                });
            });

        });
    </script>
@endpush
