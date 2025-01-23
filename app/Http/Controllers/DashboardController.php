<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\VacationRequest;
use App\Enums\VacationRequestStatus;
use App\Enums\AttendanceVerificationStatus;
use Illuminate\Contracts\Database\Query\Builder;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pendingVacationRequestCount = VacationRequest::query()
            ->where('status', VacationRequestStatus::PENDING)
            ->count();
        $pendingAttendanceVerificationCount = Attendance::query()
            ->where('verification_status', AttendanceVerificationStatus::PENDING)
            ->count();
        $todaysAttendances = Attendance::with(['user'])
            ->whereDate('date', now()->toDateString())
            ->latest();

        $request->validate([
            's' => ['nullable'],
        ]);

        if ($request->filled('s')) {
            $todaysAttendances->whereHas('user', function (Builder $query) use ($request) {
                $query->where('name', 'like', '%' . $request->s . '%');
            });
        }

        return view('dashboard', [
            'pendingVacationRequestCount' => $pendingVacationRequestCount,
            'pendingAttendanceVerificationCount' => $pendingAttendanceVerificationCount,
            'todaysAttendances' => $todaysAttendances->paginate(10),
        ]);
    }
}
