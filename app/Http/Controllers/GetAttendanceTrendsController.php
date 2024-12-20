<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceVerificationStatus;
use App\Models\Attendance;
use Illuminate\Http\Request;

class GetAttendanceTrendsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['last_days' => ['sometimes', 'numeric']]);

        $attendances = Attendance::query()
            ->select('date')
            ->selectRaw("SUM(CASE WHEN status = 'on_time' THEN 1 ELSE 0 END) as on_time")
            ->selectRaw("SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late")
            ->where('verification_status', AttendanceVerificationStatus::APPROVED)
            ->whereDate('date', '>=', now()->subDays($request->input('last_days', 7))->toDateString())
            ->groupBy('date')
            ->orderBy('date');

        return response()->json(['data' => $attendances->get()]);
    }
}
