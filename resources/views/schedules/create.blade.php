<x-layouts.admin>
    <x-slot:title>
        Create Schedule
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
            'Schedules' => route('schedules.index'),
            'Create Schedule' => '#',
        ]" />
    </x-slot:breadcrumb>

    <form action="{{ route('schedules.store', ['user' => $user]) }}" method="POST">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-2">
                <x-forms.label for="name">User
                    Name
                </x-forms.label>
                <x-forms.input type="text" name="name" id="name" value="{{ $user->name }}" disabled required />
            </div>
            <div class="w-full">
                <x-forms.label for="work_start_time">Work Start Time
                </x-forms.label>
                <x-forms.input value="{{ old('work_start_time') }}" type="time" name="work_start_time"
                    id="work_start_time" placeholder="Work Start Time" required />
                <x-forms.error name="work_start_time"></x-forms.error>

            </div>
            <div class="w-full">
                <x-forms.label for="work_end_time">Work End Time
                </x-forms.label>
                <x-forms.input value="{{ old('work_end_time') }}" type="time" name="work_end_time" id="work_end_time"
                    placeholder="Work End Time" required />
                <x-forms.error name="work_end_time"></x-forms.error>
            </div>
            <div>
                <label for="day" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Day</label>
                <select id="day" name="day"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option selected disabled>Select day</option>
                    @foreach (App\Enums\Day::options() as $day)
                        <option value="{{ $day['value'] }}"
                            {{ $day['value'] == old('day') ? 'selected' : ($day['value'] == request('day') ? 'selected' : '') }}>
                            {{ $day['label'] }}
                        </option>
                    @endforeach
                </select>
                <x-forms.error name="day"></x-forms.error>

            </div>
            <div>
                <x-forms.label for="radius">Radius (m)</x-forms.label>
                <x-forms.input value="{{ old('radius') }}" type="number" name="radius" id="radius"
                    placeholder="100" required />
                <x-forms.error name="radius"></x-forms.error>

            </div>
            <div class="sm:col-span-2">
                <label for="map" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pick
                    location</label>
                <x-forms.error name="latitude"></x-forms.error>
                <x-forms.error name="longitude"></x-forms.error>

                <div id="map"
                    class=" min-h-96 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                </div>
            </div>

            <input type="hidden" name="latitude">
            <input type="hidden" name="longitude">
        </div>
        <button type="submit"
            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            Add schedule
        </button>
    </form>

    @push('scripts')
        <script type="module">
            const map = L.map('map').setView([-8.79883, 115.161343], 20);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Initialize variables for marker and circle
            let marker;
            let circle;

            // Event listener for map click
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Set the hidden input values
                document.querySelector('input[name="latitude"]').value = lat;
                document.querySelector('input[name="longitude"]').value = lng;

                // Remove existing marker and circle if they exist
                if (marker) {
                    map.removeLayer(marker);
                }
                if (circle) {
                    map.removeLayer(circle);
                }

                // Add a new marker
                marker = L.marker([lat, lng]).addTo(map);

                // Get radius from input
                const radius = document.getElementById('radius').value;

                // Add a circle based on the radius
                if (radius) {
                    circle = L.circle([lat, lng], {
                        color: 'blue',
                        fillColor: '#30f',
                        fillOpacity: 0.5,
                        radius: radius // radius in meters
                    }).addTo(map);
                }
            });

            // Event listener for radius input change
            document.getElementById('radius').addEventListener('blur', function() {
                if (circle) {
                    const radius = this.value;
                    // Update the circle's radius
                    circle.setRadius(radius);
                }
            });
        </script>
    @endpush

</x-layouts.admin>
