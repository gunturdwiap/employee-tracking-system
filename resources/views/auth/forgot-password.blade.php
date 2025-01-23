<x-layouts.guest>

    <x-slot:title>
        Forgot Password
    </x-slot:title>

    <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Reset Your Password
            </h1>
            <p class="text-gray-700 dark:text-gray-300">
                Please enter your email address below and we will send you a link to reset your password.
            </p>
            <form class="space-y-4 md:space-y-3" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div>
                    <x-forms.label for="email">
                        Email
                    </x-forms.label>
                    <x-forms.input type="email" name="email" placeholder="company@name.com" required></x-forms.input>
                    <x-forms.error name="email"></x-forms.error>
                </div>
                <button type="submit"
                    class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Send Password Reset Link
                </button>
            </form>
            <div class="flex justify-center mt-4">
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Return to
                    Login</a>
            </div>
        </div>
    </div>

</x-layouts.guest>
