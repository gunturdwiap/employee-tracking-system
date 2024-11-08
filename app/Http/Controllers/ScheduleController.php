<?php

namespace App\Http\Controllers;

use App\Enums\Day;
use App\Enums\UserRole;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::where('role', UserRole::EMPLOYEE)
            ->with(['schedules'])
            ->paginate(5);

        /** $employees */
        // return $employees->first()->schedules->firstWhere('day', Day::FRIDAY);

        return view('schedules.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        // return response()->json($user);
        return view('schedules.create', [
            'user' => $user,
            'day' => Day::options()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $attributes = $request->validate([
            'work_start_time' => ['required'],
            'work_end_time' => ['required'],
            'day' => [
                'required',
                Rule::enum(Day::class),
                Rule::unique('schedules')->where(function ($query) use ($request, $user) {
                    return $query->where('user_id', $user->id)
                        ->where('day', $request->day);
                })
            ],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'radius' => ['required', 'numeric', ''],
        ], [
            'day.unique' => 'A schedule already exists for this employee on the selected day.',
        ]);

        $user->schedules()->create($attributes);

        return to_route('users.show', ['user' => $user])
            ->with('success', 'Schedule created');
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
        if ($schedule->user_id !== $user->id) {
            abort(404, 'Schedule not found for this user');
        }

        return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, Schedule $schedule)
    {
        if ($schedule->user_id !== $user->id) {
            abort(404, 'Schedule not found for this user');
        }

        $attributes = $request->validate([
            'work_start_time' => ['required'],
            'work_end_time' => ['required'],
            'day' => [
                'required',
                Rule::enum(Day::class),
                Rule::unique('schedules')->where(function ($query) use ($request, $user) {
                    return $query->where('user_id', $user->id)
                        ->where('day', $request->day);
                })->ignore($schedule->id)
            ],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'radius' => ['required', 'numeric'],
        ], [
            'day.unique' => 'A schedule already exists for this employee on the selected day.',
        ]);

        $schedule->update($attributes);

        return to_route('users.show', ['user' => $user])
            ->with('success', 'Schedule updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Schedule $schedule)
    {
        if ($schedule->user_id !== $user->id) {
            abort(404, 'Schedule not found for this user');
        }

        $schedule->delete();

        return back()
            ->with('success', 'Schedule deleted');
    }
}
