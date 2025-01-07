<x-layouts.admin>
    <x-slot:title>
        Profile
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
            'Profile' => '#',
        ]" />
    </x-slot:breadcrumb>

    <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid gap-4 sm:grid-cols-4 sm:gap-4 mb-4">

            <div class="w-full">
                <img class="sm:h-auto sm:w-full w-48 h-48 rounded-lg" id="profile-pic"
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . $user->name }}"
                    alt="avatar" />
            </div>

            <div class="sm:col-span-3 w-full">
                <x-forms.label for="name">Name</x-forms.label>
                <x-forms.input type="text" name="name" id="name" value="{{ $user->name }}" required />
                <x-forms.error name="name"></x-forms.error>

                <x-forms.label for="email">Email</x-forms.label>
                <x-forms.input type="email" name="email" id="email" value="{{ $user->email }}" required />
                <x-forms.error name="email"></x-forms.error>
            </div>

            <div class="w-full">
                <label for="photo" class="text-sm text-gray-700 dark:text-white cursor-pointer">
                    <span
                        class="inline-block w-48 sm:w-full font-medium rounded-lg text-sm px-5 py-2.5 text-center border border-gray-300 hover:border-primary-600 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:ring-primary-500 dark:hover:border-primary-500">Upload
                        photo</span>
                    <input type="file" name="photo" id="photo" class="hidden" value="">
                </label>
                <x-forms.error name="photo"></x-forms.error>

            </div>

            <div class="sm:col-span-3 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center text-white px-5 py-2.5 text-sm font-medium text-center bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Update Profile
                </button>
            </div>
        </div>
    </form>

    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 my-4">

    <h4 class="text-2xl font-bold dark:text-white mb-4">Change Password</h4>

    <form action="{{ route('update-password') }}" method="post">
        @csrf
        @method('PUT')
        <div class="grid gap-4 sm:grid-cols-4 sm:gap-4 mb-4">


            <div class="sm:col-span-4 w-full">
                <!-- Password -->
                <x-forms.label for="password">Password</x-forms.label>
                <x-forms.input type="password" name="password" id="password" required />
                <x-forms.error name="password"></x-forms.error>

                <!-- Confirm Password -->
                <x-forms.label for="new_password">New Password</x-forms.label>
                <x-forms.input type="password" name="new_password" id="new_password" required />
                <x-forms.error name="new_password"></x-forms.error>

                <!-- Confirm Password -->
                <x-forms.label for="new_password_confirmation">Confirm New Password</x-forms.label>
                <x-forms.input type="password" name="new_password_confirmation" id="new_password_confirmation"
                    required />
            </div>


            <div class="sm:col-span-4 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center text-white px-5 py-2.5 text-sm font-medium text-center bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Update Password
                </button>
            </div>
        </div>

    </form>

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
</x-layouts.admin>
