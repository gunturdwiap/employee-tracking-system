<?php

namespace App\Services;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function hasScheduleToday(User $user)
    {
        // Check if a schedule exists for the user today
        return Schedule::query()
            ->where('user_id', $user->id)
            ->where('day', now()->dayOfWeekIso)
            ->first();
    }

    public function hasCheckedInToday(User $user)
    {
        // Check if the user already checked in today
        return Attendance::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', now()->toDate())
            ->first();
    }

    public function isWithinCheckInTime(Carbon $checkInTime, Schedule $schedule)
    {
        return $checkInTime->between(
            $schedule->work_start_time->subMinutes(5),
            $schedule->work_end_time->addMinutes(5)
        );
    }

    public function hasCheckedOutToday(User $user)
    {
        return Attendance::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', now()->toDate())
            ->whereNotNull('check_out_time')
            ->exists();
    }

    public function isWithinCheckOutTime(Carbon $checkOutTime, Schedule $schedule)
    {
        // 5 min grace period?
        return $checkOutTime->between(
            $schedule->work_start_time->subMinutes(5),
            $schedule->work_end_time->addMinutes(5)
        );
    }

    public function isWithinRadius(float $lat1, float $lon1, float $lat2, float $lon2, int $radius)
    {
        // Convert latitude and longitude from degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Convert m to km
        $radius = $radius / 1000;

        // Earth radius in kilometers
        $earthRadius = 6371;

        // Calculate the differences
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        // Apply the Haversine formula
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Calculate the distance
        $distance = $earthRadius * $c;

        // Check if the distance is within the specified radius
        return $distance <= $radius;


        // Example usage:
        // $referenceLat = 40.730610;  // Replace with reference latitude
        // $referenceLon = -73.935242; // Replace with reference longitude
        // $targetLat = 40.730700;     // Replace with target latitude
        // $targetLon = -73.935300;    // Replace with target longitude
        // $radius = 0.5; // Radius in kilometers (e.g., 500 meters)

        // if (isWithinRadius($referenceLat, $referenceLon, $targetLat, $targetLon, $radius)) {
        //     echo "The point is within the radius.";
        // } else {
        //     echo "The point is outside the radius.";
        // }
    }
}
