<x-layouts.guest>

    <x-slot:title>
        Register
    </x-slot:title>

    <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Create an account
            </h1>
            <form class="space-y-4 md:space-y-3" action="{{ route('register') }}" method="POST">
                @csrf
                <div>
                    <x-forms.label for="name">
                        Name
                    </x-forms.label>
                    <x-forms.input type="text" name="name" placeholder="name"></x-forms.input>
                    <x-forms.error name="name"></x-forms.error>
                </div>
                <div>
                    <x-forms.label for="email">
                        Email
                    </x-forms.label>
                    <x-forms.input type="email" name="email" placeholder="company@name.com"></x-forms.input>
                    <x-forms.error name="email"></x-forms.error>
                </div>
                <div>
                    <x-forms.label for="password">Password</x-forms.label>
                    <x-forms.input type="password" name="password" placeholder="••••••••" required></x-forms.input>
                    <x-forms.error name="password"></x-forms.error>
                </div>
                <div>
                    <x-forms.label for="password_confirmation">Confirm Password</x-forms.label>
                    <x-forms.input type="password" name="password_confirmation" placeholder="••••••••"
                        required></x-forms.input>
                    <x-forms.error name="password_confirmation"></x-forms.error>
                </div>
                <button type="submit"
                    class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create
                    an account</button>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    Already have an account? <a href="{{ route('login') }}"
                        class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a>
                </p>
            </form>
        </div>
    </div>
</x-layouts.guest>
