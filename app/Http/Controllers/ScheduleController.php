<?php

namespace App\Http\Controllers;

use App\Enums\Day;
use Carbon\Carbon;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = User::where('role', UserRole::EMPLOYEE)
            ->with(['schedules']);

        $request->validate([
            's' => ['nullable', 'string'],
        ]);


        if ($request->filled('s')) {
            $employees->where('name', 'like', '%' . $request->s . '%');
        }

        return view('schedules.index', [
            'employees' => $employees->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('schedules.create', [
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $attributes = $request->validate([
            'work_start_time' => ['required', 'date_format:H:i', 'before:work_end_time'],
            'work_end_time' => ['required', 'date_format:H:i', 'after:work_start_time'],
            'day' => [
                'required',
                Rule::enum(Day::class),
                Rule::unique('schedules')->where(function ($query) use ($request, $user) {
                    return $query->where('user_id', $user->id)
                        ->where('day', $request->day);
                })
            ],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'radius' => ['required', 'numeric'],
        ], [
            'day.unique' => 'A schedule already exists for this employee on the selected day.',
        ]);

        $user->schedules()->create($attributes);

        return back()->with('success', 'Schedule created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Schedule $schedule)
    {
        // return response()->json($schedule);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Schedule $schedule)
    {
        return view('schedules.edit', [
            'schedule' => $schedule->load('user')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, Schedule $schedule)
    {
        $attributes = $request->validate([
            'work_start_time' => ['required', 'date_format:H:i'],
            'work_end_time' => ['required', 'date_format:H:i'],
            'day' => [
                'required',
                Rule::enum(Day::class),
                Rule::unique('schedules')->where(function ($query) use ($request, $user) {
                    return $query->where('user_id', $user->id)
                        ->where('day', $request->day);
                })->ignore($schedule->id)
            ],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'radius' => ['required', 'numeric'],
        ], [
            'day.unique' => 'A schedule already exists for this employee on the selected day.',
        ]);

        $schedule->update($attributes);

        return back()->with('success', 'Schedule updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Schedule $schedule)
    {
        $schedule->delete();

        return back()
            ->with('success', 'Schedule deleted');
    }
}
