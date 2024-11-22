<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceVerificationStatus;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VerifyAttendanceController extends Controller
{
    public function __invoke(Request $request, Attendance $attendance)
    {
        $request->validate([
            'verification_status' => [
                'required',
                Rule::enum(AttendanceVerificationStatus::class)
                    ->except(AttendanceVerificationStatus::PENDING)
            ]
        ]);

        $attendance->update([
            'verification_status' => $request->verification_status
        ]);

        return to_route('attendances.index')->with('success', 'Attendance verification status updated');
    }
}
