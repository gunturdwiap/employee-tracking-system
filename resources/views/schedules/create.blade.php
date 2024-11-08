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

    <div>
        <h2>schedule form for {{ $user->name }}</h2>
        <form action="{{ route('schedules.store', ['user' => $user]) }}" method="post">
            @csrf
            <ul>
                <li>
                    <label for="">
                        day
                    </label>
                    <select name="day" id="">
                        <option value="" selected disabled></option>
                        @foreach ($day as $day)
                            <option value="{{ $day['value'] }}"
                                {{ $day['value'] == old('day') ? 'selected' : ($day['value'] == request('day') ? 'selected' : '') }}>
                                {{ $day['label'] }}
                            </option>
                        @endforeach
                    </select>
                </li>

                <li>
                    <label for="">start</label>
                    <input value="{{ old('work_start_time') }}" type="time" name="work_start_time" id="">
                </li>
                <li>
                    <label for="">end</label>
                    <input value="{{ old('work_end_time') }}" type="time" name="work_end_time" id="">
                </li>
                <li>
                    <label for="">radius</label>
                    <input value="{{ old('radius') }}" type="number" name="radius" id="">
                </li>
                <li>
                    <label for="">lat</label>
                    <input value="{{ old('latitude') }}" type="number" name="latitude" id="">
                </li>
                <li>
                    <label for="">long</label>
                    <input value="{{ old('longitude') }}" type="number" name="longitude" id="">
                </li>
            </ul>
            <button type="submit" class="rounded bg-primary-500 p-3 shadow text-slate-100">submit</button>
        </form>
        @if ($errors->any())
            <div class="text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

</x-layouts.admin>
