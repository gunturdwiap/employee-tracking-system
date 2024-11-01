<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Enums\AttendanceStatus;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.attendance', [
            'schedule' => Schedule::query()
                ->where('user_id', auth()->id())
                ->where('day', strtolower(now()->format('l')))
                ->first()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Check if a schedule exists for the user today
        $schedule = Schedule::query()
            ->where('user_id', $user->id)
            ->where('day', strtolower(now()->format('l')))
            ->first();

        if (!$schedule) {
            return to_route('employee.attendance')->with('danger', 'No schedule found for today');
        }

        // Check if the user already checked in today
        $checkIn = Attendance::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', now()->toDate())
            ->first();

        if ($checkIn) {
            return to_route('employee.attendance')->with('danger', 'Already checked in');
        }

        // Validate data
        $attributes = $request->validate([
            'latitude' => ['required'],
            'longitude' => ['required'],
        ]);

        // Check time
        $checkInTime = now();

        /** @var \Carbon\Carbon $schedule->work_start_time  */
        /** @var \Carbon\Carbon $schedule->work_end_time  */
        if (!$checkInTime->between($schedule->work_start_time->subMinutes(5), $schedule->work_end_time->addMinutes(5))) {
            return to_route('employee.attendance')->with('danger', 'Invalid check in time');
        }

        // TODO: Check location
        if (!true) {
            return to_route('employee.attendance')->with('danger', 'Invalid check in location');
        }

        // TODO: Check attendance time

        // Create record
        $user->attendances()->create([
            'date' => $checkInTime->format('Y-m-d'),
            'check_in_time' => $checkInTime->format('H:i'),
            'status' => AttendanceStatus::ON_TIME,
        ]);

        // Return
        return to_route('employee.attendance')->with('success', 'Check in success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Check if a schedule exists for the user today
        $schedule = Schedule::query()
            ->where('user_id', $user->id)
            ->where('day', strtolower(now()->format('l')))
            ->first();

        //Check if the user already checked in today
        $checkIn = Attendance::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', now()->toDate())
            ->first();

        if (!$checkIn) {
            return to_route('employee.attendance')->with('danger', 'Please check in first');
        }

        //Check if the user already checked out today
        $checkOut = Attendance::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', now()->toDate())
            ->whereNotNull('check_out_time')
            ->first();

        if ($checkOut) {
            return to_route('employee.attendance')->with('danger', 'Already checked out');
        }

        // Validate data
        $attributes = $request->validate([
            'latitude' => ['required'],
            'longitude' => ['required'],
        ]);

        // Check time
        $checkOutTime = now();

        /** @var \Carbon\Carbon $schedule->work_start_time  */
        /** @var \Carbon\Carbon $schedule->work_end_time  */
        if (!$checkOutTime->between($schedule->work_start_time->subMinutes(5), $schedule->work_end_time->addMinutes(5))) {
            return to_route('employee.attendance')->with('danger', 'Invalid check out time');
        }

        // TODO: Check location
        if (!true) {
            return to_route('employee.attendance')->with('danger', 'Invalid check in location');
        }

        // Update record
        $checkIn->update([
            'check_out_time' => $checkOutTime->format('H:i')
        ]);

        // Return
        return to_route('employee.attendance')->with('success', 'Check out success');
    }
}
