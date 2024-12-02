<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceVerificationStatus;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Services\PhotoService;
use App\Enums\AttendanceStatus;
use App\Services\AttendanceService;

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
        if (!$this->attendanceService->isWithinCheckInTime($schedule->work_start_time, $checkInTime)) {
            return to_route('employee.attendance')->with('danger', 'Invalid check in time');
        }

        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'photo' => ['required', 'string']
        ]);

        if (!$this->attendanceService->isWithinRadius($$request->latitude, $request->longitude, $schedule->latitude, $schedule->longitude, $schedule->radius)) {
            return to_route('employee.attendance')->with('danger', 'Invalid check in location');
        }

        try {
            $imageName = PhotoService::saveBase64Image($request->photo, 'checkin');

            $user->attendances()->create([
                'date' => $checkInTime->format('Y-m-d'),
                'check_in_time' => $checkInTime->format('H:i'),
                'status' => AttendanceStatus::ON_TIME, //TODO
                'verification_status' => AttendanceVerificationStatus::PENDING,
                'check_in_photo' => $imageName
            ]);

            return to_route('employee.attendance')->with('success', 'Check in success');
        } catch (\Exception $e) {
            return to_route('employee.attendance')->with('danger', 'Check in failed : ' . $e->getMessage());
        }
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
        if (!$this->attendanceService->isWithinCheckOutTime($schedule->work_end_time, $checkOutTime)) {
            return to_route('employee.attendance')->with('danger', 'Invalid check out time');
        }

        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'photo' => ['required', 'string'],
        ]);

        if (!$this->attendanceService->isWithinRadius($request->latitude, $request->longitude, $schedule->latitude, $schedule->longitude, $schedule->radius)) {
            return to_route('employee.attendance')->with('danger', 'Invalid check out location');
        }

        try {
            $imageName = PhotoService::saveBase64Image($request->photo, 'checkout');

            $checkIn->update([
                'check_out_time' => $checkOutTime->format('H:i'),
                'check_out_photo' => $imageName
            ]);

            return to_route('employee.attendance')->with('success', 'Check out success');
        } catch (\Exception $e) {
            return to_route('employee.attendance')->with('danger', 'Check out failed : ' . $e->getMessage());
        }
    }
}
