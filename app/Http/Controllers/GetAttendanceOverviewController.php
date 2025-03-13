<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceVerificationStatus;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class GetAttendanceOverviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['from' => ['sometimes', 'date:Y-m-d'], 'to' => ['sometimes', 'date:Y-m-d']]);

        $attendances = Attendance::selectRaw('status, COUNT(*) as count')
            ->where('verification_status', AttendanceVerificationStatus::APPROVED)
            ->groupBy('status');

        if ($request->filled(['from', 'to'])) {
            $attendances->where(function (Builder $query) use ($request) {
                $query->whereDate('date', '>=', $request->from)
                    ->whereDate('date', '<=', $request->to);
            });
        } else {
            $attendances->whereDate('date', date('Y-m-d'));
        }

        return response()->json(['data' => $attendances->get()]);
    }
}
