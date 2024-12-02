<?php

namespace App\Services;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceService
{
    const GRACE_PERIOD = 30; // 30 Min

    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function hasScheduleToday(User $user)
    {
        return Schedule::query()
            ->where('user_id', $user->id)
            ->where('day', now()->dayOfWeekIso)
            ->first();
    }

    public function hasCheckedInToday(User $user)
    {
        return Attendance::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', now()->toDate())
            ->first();
    }

    public function isWithinCheckInTime(Carbon $startTime, Carbon $checkInTime)
    {
        return $checkInTime->between(
            $startTime->subMinutes(self::GRACE_PERIOD),
            $startTime->addMinutes(self::GRACE_PERIOD)
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

    public function isWithinCheckOutTime(Carbon $endTime, Carbon $checkOutTime)
    {
        return $checkOutTime->between(
            $endTime->subMinutes(self::GRACE_PERIOD),
            $endTime->addMinutes(self::GRACE_PERIOD)
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
    }
}
