<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\VacationRequest;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $pendingVacationRequestCount = VacationRequest::where('status', 'pending')->count();
        $pendingAttendanceVerificationCount = Attendance::where('verification_status', 'pending')->count();
        return view('dashboard', ['pendingVacationRequestCount' => $pendingVacationRequestCount, 'pendingAttendanceVerificationCount' => $pendingAttendanceVerificationCount]);
    }
}
