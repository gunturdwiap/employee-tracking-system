<?php

namespace App\Services;

use App\Enums\AttendanceStatus;
use App\Enums\AttendanceVerificationStatus;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class AttendanceService
{
    const GRACE_PERIOD = 30; // 30 Min

    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function checkIn(User $user, Carbon $checkInTime, float $latitude, float $longitude, UploadedFile $photo)
    {
        $schedule = $this->hasScheduleToday($user);
        if (! $schedule) {
            throw ValidationException::withMessages(['check_in_time' => 'No schedule found for today']);
        }

        if ($this->hasCheckedInToday($user)) {
            throw ValidationException::withMessages(['check_in_time' => 'You have already checked in today.']);
        }

        if (! $this->isWithinCheckInTime($schedule->work_start_time, $checkInTime)) {
            throw ValidationException::withMessages(['check_in_time' => 'Invalid check in time']);
        }

        if (! $this->isWithinRadius($latitude, $longitude, $schedule->latitude, $schedule->longitude, $schedule->radius)) {
            throw ValidationException::withMessages(['check_in_time' => 'Invalid check in location']);
        }

        $path = $photo->store('photos', 'public');

        return $user->attendances()->create([
            'date' => $checkInTime->format('Y-m-d'),
            'check_in_time' => $checkInTime->format('H:i'),
            'status' => AttendanceStatus::ON_TIME,
            'verification_status' => AttendanceVerificationStatus::PENDING,
            'check_in_photo' => $path,
        ]);
    }

    public function checkOut(User $user, Carbon $checkOutTime, float $latitude, float $longitude, UploadedFile $photo)
    {
        $schedule = $this->hasScheduleToday($user);
        if (! $schedule) {
            throw ValidationException::withMessages(['check_out_time' => 'No schedule found for today']);
        }

        $checkIn = $this->hasCheckedInToday($user);
        if (! $checkIn) {
            throw ValidationException::withMessages(['check_out_time' => 'Please check in first']);
        }

        if ($this->hasCheckedOutToday($user)) {
            throw ValidationException::withMessages(['check_out_time' => 'You have already checked out today.']);
        }

        $checkOutTime = now();
        if (! $this->isWithinCheckOutTime($schedule->work_end_time, $checkOutTime)) {
            throw ValidationException::withMessages(['check_out_time' => 'Invalid check out time']);
        }

        if (! $this->isWithinRadius($latitude, $longitude, $schedule->latitude, $schedule->longitude, $schedule->radius)) {
            throw ValidationException::withMessages(['check_out_time' => 'Invalid check out location']);
        }

        $path = $photo->store('photos', 'public');

        return $checkIn->update([
            'check_out_time' => $checkOutTime->format('H:i'),
            'check_out_photo' => $path,
        ]);
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
        $startTimeBefore = $startTime->copy()->subMinutes(self::GRACE_PERIOD);
        $startTimeAfter = $startTime->copy()->addMinutes(self::GRACE_PERIOD);

        return $checkInTime->between($startTimeBefore, $startTimeAfter);
    }

    public function hasCheckedOutToday(User $user)
    {
        return Attendance::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', now()->toDate())
            ->whereNotNull('check_out_time')
            ->first();
    }

    public function isWithinCheckOutTime(Carbon $endTime, Carbon $checkOutTime)
    {
        $endTimeBefore = $endTime->copy()->subMinutes(self::GRACE_PERIOD);
        $endTimeAfter = $endTime->copy()->addMinutes(self::GRACE_PERIOD);

        return $checkOutTime->between($endTimeBefore, $endTimeAfter);
    }

    public function isWithinRadius(float $lat1, float $lon1, float $lat2, float $lon2, int $radius)
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance <= $radius;
    }
}
