<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attendances = Attendance::query()->with(['user']);

        if ($request->filled('s')) {
            $attendances->whereHas('user', function (Builder $query) use ($request) {
                $query->where('name', $request->s);
            });
        }

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
        } else {
            $attendances->whereDate('date', date('Y-m-d'));
        }

        dump($attendances->toRawSql());

        return view('attendances.index', [
            'attendances' => $attendances->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        return view('attendances.show', ['attendance' => $attendance]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
