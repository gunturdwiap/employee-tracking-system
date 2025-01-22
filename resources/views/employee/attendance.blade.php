<x-layouts.employee>
    <x-slot:title>
        Attendance
    </x-slot:title>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2 mx-auto mt-4">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Hallo {{ auth()->user()->name }}</h5>
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

            <video id="video" style="width: 100%; max-width: 400px; display: block; margin: 0 auto;" class="rounded-lg"
                autoplay></video>
            <canvas id="canvas" style="display: none;"></canvas>

            <p id="distance" class="text-lg font-medium text-gray-900 dark:text-white">

            </p>

            <form id="checkinForm" method="POST" action="{{ route('checkin') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" id="photoCheckin" name="photo" style="display: none;">
                <input type="hidden" id="latitudeCheckin" name="latitude">
                <input type="hidden" id="longitudeCheckin" name="longitude">
                <button type="submit"
                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">Check
                    In</button>

            </form>

            <form id="checkoutForm" method="POST" action="{{ route('checkout') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="file" id="photoCheckout" name="photo" style="display: none;">
                <input type="hidden" id="latitudeCheckout" name="latitude">
                <input type="hidden" id="longitudeCheckout" name="longitude">
                <button type="submit"
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Check
                    Out</button>
            </form>
        @endif
    </div>

    @push('scripts')
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {
                startCamera();
                setupFormHandlers();
                // yes
                {{ $schedule ? 'updateDistance(1000)' : '' }}

            });

            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const redirectUrl = '{{ route('employee.schedule') }}'
            let stream;
            let errorShown;

            async function startCamera() {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    video.srcObject = stream;
                } catch (error) {
                    swalError('Camera permission is required.')
                        .then(() => window.location.href = redirectUrl);
                }
            }

            async function getLocation() {
                try {
                    const position = await new Promise((resolve, reject) => {
                        navigator.geolocation.getCurrentPosition(resolve, reject);
                    });

                    return {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };
                } catch (error) {
                    if (errorShown) {
                        return;
                    }

                    swalError('Location permission is required.')
                        .then(() => window.location.href = redirectUrl);

                    errorShown = true;
                }
            }

            async function capturePhoto() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                return new Promise((resolve) => {
                    canvas.toBlob((blob) => {
                        const file = new File([blob], `photo_${Date.now()}.jpg`, {
                            type: 'image/jpeg'
                        });
                        resolve(file);
                    }, 'image/jpeg');
                });
            }

            async function handleSubmit(formId, photoInputId, latitudeInputId, longitudeInputId) {
                //disable all submit button
                document.querySelectorAll('button[type="submit"]').forEach((button) => {
                    button.disabled = true;
                });
                const {
                    latitude,
                    longitude
                } = await getLocation();

                const photoFile = await capturePhoto();
                const dataTransfer = new DataTransfer();

                // Log the file for debugging
                // console.log('Captured photo file:', photoFile);

                dataTransfer.items.add(photoFile);
                const fileInput = document.getElementById(photoInputId);
                fileInput.files = dataTransfer.files;

                // Log the file input for debugging
                // console.log('File input after setting files:', fileInput.files);

                document.getElementById(latitudeInputId).value = latitude;
                document.getElementById(longitudeInputId).value = longitude;

                // Submit the form
                document.getElementById(formId).submit();
            }

            function setupFormHandlers() {
                document.getElementById('checkinForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    handleSubmit('checkinForm', 'photoCheckin', 'latitudeCheckin', 'longitudeCheckin');
                });

                document.getElementById('checkoutForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    handleSubmit('checkoutForm', 'photoCheckout', 'latitudeCheckout', 'longitudeCheckout');
                });
            }

            function haversineDistance(lat1Deg, lon1Deg, lat2Deg, lon2Deg) {
                function toRad(degree) {
                    return degree * Math.PI / 180;
                }

                const lat1 = toRad(lat1Deg);
                const lon1 = toRad(lon1Deg);
                const lat2 = toRad(lat2Deg);
                const lon2 = toRad(lon2Deg);

                const {
                    sin,
                    cos,
                    sqrt,
                    atan2
                } = Math;

                const R = 6371; // earth radius in km
                const dLat = lat2 - lat1;
                const dLon = lon2 - lon1;
                const a = sin(dLat / 2) * sin(dLat / 2) +
                    cos(lat1) * cos(lat2) *
                    sin(dLon / 2) * sin(dLon / 2);
                const c = 2 * atan2(sqrt(a), sqrt(1 - a));
                const d = R * c;
                return d * 1000; // distance in m
            }

            function updateDistance(interval) {
                const scheduleLat = {{ $schedule?->latitude ?? 0 }};
                const scheduleLong = {{ $schedule?->longitude ?? 0 }};
                const distance = document.querySelector('#distance');

                setInterval(async function() {
                    let {
                        latitude,
                        longitude
                    } = await getLocation();
                    let result = Math.round(haversineDistance(latitude, longitude, scheduleLat, scheduleLong));
                    // console.log(result, {
                    //     latitude,
                    //     longitude
                    // });
                    distance.innerHTML = `Jarak dari pusat lokasi : ${result} m`;
                }, interval);
            }
        </script>
    @endpush
</x-layouts.employee>
