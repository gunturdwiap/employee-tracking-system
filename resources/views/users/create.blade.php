<x-layouts.admin>
    <x-slot:title>
        Create User
    </x-slot:title>

    <x-slot:breadcrumb>
        <x-breadcrumb :links="[
            'Home' => route('dashboard'),
            'Users' => route('users.index'),
            'Create User' => '#',
        ]" />
    </x-slot:breadcrumb>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <!-- Name -->
            <div class="w-full">
                <x-forms.label for="name">Name</x-forms.label>
                <x-forms.input type="text" name="name" id="name" value="{{ old('name') }}" required />
                <x-forms.error name="name"></x-forms.error>
            </div>

            <!-- Email -->
            <div class="w-full">
                <x-forms.label for="email">Email</x-forms.label>
                <x-forms.input type="email" name="email" id="email" value="{{ old('email') }}" required />
                <x-forms.error name="email"></x-forms.error>
            </div>

            <!-- Password -->
            <div class="w-full">
                <x-forms.label for="password">Password</x-forms.label>
                <x-forms.input type="password" name="password" id="password" required />
                <x-forms.error name="password"></x-forms.error>
            </div>

            <!-- Confirm Password -->
            <div class="w-full">
                <x-forms.label for="password_confirmation">Confirm Password</x-forms.label>
                <x-forms.input type="password" name="password_confirmation" id="password_confirmation" required />
                <x-forms.error name="password_confirmation"></x-forms.error>
            </div>

            <!-- Role -->
            <div class="w-full">
                <x-forms.label for="role">Role</x-forms.label>
                <select id="role" name="role" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option selected disabled>Select Role</option>
                    @foreach (App\Enums\UserRole::cases() as $role)
                        <option value="{{ $role->value }}" {{ $role->value == old('role') ? 'selected' : '' }}>
                            {{ $role->name }}</option>
                    @endforeach
                </select>
                <x-forms.error name="role"></x-forms.error>
            </div>
        </div>

        <button type="submit"
            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            Create User
        </button>
    </form>
</x-layouts.admin>
