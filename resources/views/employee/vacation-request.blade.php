<x-layouts.employee>
    <x-slot:title>
        Vacation Request
    </x-slot:title>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2 mx-auto mt-4">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Vacation Request</h5>
        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">

        <form action="" method="post" x-data="{ today: (new Date()).toISOString().split('T')[0] }" class="grid gap-4">
            @csrf
            <div>
                <x-forms.label for="start">
                    Start date
                </x-forms.label>
                <x-forms.input name="start" type="date" x-bind:min="today"></x-forms.input>
                <x-forms.error name="start"></x-forms.error>
            </div>

            <div>
                <x-forms.label for="end">
                    End date
                </x-forms.label>
                <x-forms.input name="end" type="date" x-bind:min="today"></x-forms.input>
                <x-forms.error name="end"></x-forms.error>
            </div>

            <div>

                <x-forms.label for="reason">
                    Reason
                </x-forms.label>
                <textarea id="message" rows="4" name="reason"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="...">{{ old('reason') }}</textarea>
                {{-- <textarea name="reason" id="" cols="30" rows="10">{{ old('reason') }}</textarea> --}}
                <x-forms.error name="reason"></x-forms.error>
            </div>
            <button
                class="w-full text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Submit</button>
        </form>
    </div>


</x-layouts.employee>
