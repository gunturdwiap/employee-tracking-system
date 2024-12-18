<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class GetAttendanceOverviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['from' => 'date:Y-m-d', 'to' => 'date:Y-m-d']);

        $attendances = Attendance::selectRaw('status, COUNT(*) as count')
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
