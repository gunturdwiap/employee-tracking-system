<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use App\Enums\AttendanceStatus;

class EmployeeAttendanceController extends Controller
{

    public function __construct(protected AttendanceService $attendanceService)
    {
    }

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
            'schedule' => $this->attendanceService->hasScheduleToday(request()->user())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $schedule = $this->attendanceService->hasScheduleToday($user);
        if (!$schedule) {
            return to_route('employee.attendance')->with('danger', 'No schedule found for today');
        }

        if ($this->attendanceService->hasCheckedInToday($user)) {
            return to_route('employee.attendance')->with('danger', 'Already checked in');
        }

        $checkInTime = now();
        if (!$this->attendanceService->isWithinCheckInTime($checkInTime, $schedule)) {
            return to_route('employee.attendance')->with('danger', 'Invalid check in time');
        }


        $attributes = $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        if (!$this->attendanceService->isWithinRadius($attributes['latitude'], $attributes['longitude'], $schedule->latitude, $schedule->longitude, $schedule->radius)) {
            return to_route('employee.attendance')->with('danger', 'Invalid check in location');
        }

        $user->attendances()->create([
            'date' => $checkInTime->format('Y-m-d'),
            'check_in_time' => $checkInTime->format('H:i'),
            'status' => AttendanceStatus::ON_TIME, //TODO
        ]);

        return to_route('employee.attendance')->with('success', 'Check in success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $schedule = $this->attendanceService->hasScheduleToday($user);

        $checkIn = $this->attendanceService->hasCheckedInToday($user);
        if (!$checkIn) {
            return to_route('employee.attendance')->with('danger', 'Please check in first');
        }

        if ($this->attendanceService->hasCheckedOutToday($user)) {
            return to_route('employee.attendance')->with('danger', 'Already checked out');
        }

        $checkOutTime = now();
        if (!$this->attendanceService->isWithinCheckOutTime($checkOutTime, $schedule)) {
            return to_route('employee.attendance')->with('danger', 'Invalid check out time');
        }

        $attributes = $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        if (!$this->attendanceService->isWithinRadius($attributes['latitude'], $attributes['longitude'], $schedule->latitude, $schedule->longitude, $schedule->radius)) {
            return to_route('employee.attendance')->with('danger', 'Invalid check out location');
        }

        $checkIn->update([
            'check_out_time' => $checkOutTime->format('H:i')
        ]);

        return to_route('employee.attendance')->with('success', 'Check out success');
    }
}
