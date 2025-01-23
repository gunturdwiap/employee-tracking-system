<x-layouts.employee>
    <x-slot:title>
        Profile
    </x-slot:title>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2 mx-auto mt-4">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white text-center">Profile</h5>
        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
        <form class="grid gap-4" method="POST" action="{{ route('update-profile') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Profile pic --}}
            <div class="flex items-center justify-center">
                <img id="profile-pic"
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . $user->name }}"
                    alt="profile picture" class="w-24 h-24 rounded-full object-cover bg-black">
                </img>
            </div>
            {{-- Input img --}}
            <div class="flex items-center justify-center">
                <label for="photo" class="text-sm text-gray-700 dark:text-white cursor-pointer">
                    <span
                        class="w-full text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Upload
                        photo</span>
                    <input type="file" name="photo" id="photo" class="hidden" value="">
                </label>
            </div>
            <x-forms.error name="photo"></x-forms.error>

            <div>
                <x-forms.label for="name">
                    Name
                </x-forms.label>
                <x-forms.input name="name" type="text" value="{{ $user->name }}"></x-forms.input>
                <x-forms.error name="name"></x-forms.error>
            </div>

            <div>
                <x-forms.label for="email">
                    Email
                </x-forms.label>
                <x-forms.input name="email" type="email" value="{{ $user->email }}"></x-forms.input>
                <x-forms.error name="email"></x-forms.error>
            </div>

            <button
                class="w-full text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Edit
                Profile</button>
        </form>
    </div>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2 mx-auto mt-4">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Change Password</h5>
        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
        <form class="grid gap-4" method="POST" action="{{ route('update-password') }}">
            @csrf
            @method('PUT')
            <div>
                <x-forms.label for="password">
                    Password
                </x-forms.label>
                <x-forms.input name="password" type="password"></x-forms.input>
                <x-forms.error name="password"></x-forms.error>
            </div>

            <div>
                <x-forms.label for="new_password">
                    New Password
                </x-forms.label>
                <x-forms.input name="new_password" type="password"></x-forms.input>
                <x-forms.error name="new_password"></x-forms.error>
            </div>

            <div>
                <x-forms.label for="new_password_confirmation">
                    Confirm New Password
                </x-forms.label>
                <x-forms.input name="new_password_confirmation" type="password"></x-forms.input>
            </div>

            <button
                class="w-full text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Change
                Password</button>
        </form>
    </div>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2 mx-auto mt-4">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">History</h5>
        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

        <div
            class="w-full text-sm font-medium text-gray-900 border-gray-200dark:bg-gray-700 dark:border-gray-600 dark:text-white gap-4">
            <a href="{{ route('employee.attendance-history') }}"
                class="flex items-center gap-2 px-5 py-2.5 w-full rounded-lg border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-700 focus:text-primary-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Attendance History
            </a>
            <a href="{{ route('employee.vacation-request-history') }}"
                class="flex items-center gap-2  px-5 py-2.5 w-full rounded-lg border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-700 focus:text-primary-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>

                Vacation Request History
            </a>
        </div>

    </div>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2 mx-auto mt-4">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Sign
                out</button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initPhotoHandler();
            });

            const initPhotoHandler = () => {
                const photo = document.getElementById('photo');
                const profilePic = document.getElementById('profile-pic');

                photo.addEventListener('change', function() {
                    const file = this.files[0];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        profilePic.src = e.target.result;
                    }

                    reader.readAsDataURL(file);
                });
            }
        </script>
    @endpush
</x-layouts.employee>
