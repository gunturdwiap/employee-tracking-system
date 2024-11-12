<x-layouts.employee>
    <x-slot:title>
        Attendance
    </x-slot:title>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Hallo bang {{ auth()->user()->name }}</h5>
        <p class="text-lg font-medium text-gray-900 dark:text-white">
            {{ now()->format('Y-m-d H:i:s') }}, {{ config('app.timezone') }}
        </p>

        @if (!$schedule)
            <p class="text-lg font-medium text-gray-900 dark:text-white">
                Nggak ada jadwal hari ini coy
            </p>
        @else
            <p class="text-lg font-medium text-gray-900 dark:text-white">
                Jadwal hari ini : {{ $schedule->work_start_time->format('H:i') }} -
                {{ $schedule->work_end_time->format('H:i') }}
            </p>
            <p class="text-lg font-medium text-gray-900 dark:text-white">
                Jarak dari lokasi :
            </p>

            <form action="{{ route('checkin') }}" method="post" id="checkinForm">
                @csrf
                <input type="hidden" name="latitude" id="latitudeCheckin">
                <input type="hidden" name="longitude" id="longitudeCheckin">
                <button
                    class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Presensi mulai
                </button>
            </form>

            <form action="{{ route('checkout') }}" method="post" id="checkoutForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="latitude" id="latitudeCheckout">
                <input type="hidden" name="longitude" id="longitudeCheckout">
                <button
                    class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    Presensi selesai
                </button>
            </form>
        @endif
    </div>

    @push('scripts')
        <script>
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Set the latitude and longitude values in the forms
                    document.getElementById('latitudeCheckin').value = position.coords.latitude;
                    document.getElementById('longitudeCheckin').value = position.coords.longitude;
                    document.getElementById('latitudeCheckout').value = position.coords.latitude;
                    document.getElementById('longitudeCheckout').value = position.coords.longitude;
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        </script>
    @endpush
</x-layouts.employee>
