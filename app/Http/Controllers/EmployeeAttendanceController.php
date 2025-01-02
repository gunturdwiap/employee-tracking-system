<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AttendanceService;

class EmployeeAttendanceController extends Controller
{

    public function __construct(protected AttendanceService $attendanceService)
    {
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
        try {
            $request->validate([
                'latitude' => ['bail', 'required', 'numeric'],
                'longitude' => ['bail', 'required', 'numeric'],
                'photo' => ['bail', 'required', 'image']
            ]);
            $this->attendanceService->checkIn($request->user(), now(), $request->latitude, $request->longitude, $request->file('photo'));
        } catch (\Exception $e) {
            return to_route('employee.attendance')->with('danger', $e->getMessage());
        }
        return to_route('employee.attendance')->with('success', 'Check in success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'latitude' => ['bail', 'required', 'numeric'],
                'longitude' => ['bail', 'required', 'numeric'],
                'photo' => ['bail', 'required', 'image'],
            ]);
            $this->attendanceService->checkOut($request->user(), now(), $request->latitude, $request->longitude, $request->file('photo'));
        } catch (\Exception $e) {
            return to_route('employee.attendance')->with('danger', $e->getMessage());
        }
        return to_route('employee.attendance')->with('success', 'Check out success');
    }
}
