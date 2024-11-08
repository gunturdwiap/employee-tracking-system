<x-layouts.employee>
    <x-slot:title>
        Vacation Request
    </x-slot:title>

    <div
        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 space-y-2">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Hallo bang {{ auth()->user()->name }}</h5>

        <form action="" method="post" x-data="{ today: (new Date()).toISOString().split('T')[0] }">
            @csrf
            <x-forms.input name="start" type="date" x-bind:min="today"></x-forms.input>
            <x-forms.error name="start"></x-forms.error>

            <x-forms.input name="end" type="date" x-bind:min="today"></x-forms.input>
            <x-forms.error name="end"></x-forms.error>

            <textarea name="reason" id="" cols="30" rows="10">{{ old('reason') }}</textarea>
            <x-forms.error name="reason"></x-forms.error>
            <button
                class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Submit</button>
        </form>
    </div>


</x-layouts.employee>
