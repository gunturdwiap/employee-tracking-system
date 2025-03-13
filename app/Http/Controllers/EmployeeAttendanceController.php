<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class EmployeeAttendanceController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attendances = Attendance::query()->where('user_id', $request->user()->id);

        $request->validate([
            'status' => ['nullable'],
            'verification_status' => ['nullable'],
            'from' => ['nullable', 'date:Y-m-d'],
            'to' => ['nullable', 'date:Y-m-d'],
        ]);

        if ($request->filled('status')) {
            $attendances->where('status', $request->status);
        }

        if ($request->filled('verification_status')) {
            $attendances->where('verification_status', $request->verification_status);
        }

        if ($request->filled(['from', 'to'])) {
            $attendances->where(function (Builder $query) use ($request) {
                $query->whereDate('date', '>=', $request->from)
                    ->whereDate('date', '<=', $request->to);
            });
        }

        return view('employee.attendance-history', [
            'attendances' => $attendances->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.attendance', [
            'schedule' => $this->attendanceService->hasScheduleToday(request()->user()),
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
                'photo' => ['bail', 'required', 'image'],
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
