<?php

namespace App\Console\Commands;

use App\Enums\AttendanceStatus;
use App\Enums\AttendanceVerificationStatus;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Console\Command;

class UpdateAbsentAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-absent-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark employees as absent if they did not check in';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        // Get schedules for today
        $schedules = Schedule::where('day', now()->isoWeekday())->get();

        // Mark employees as absent if they did not check in
        foreach ($schedules as $schedule) {
            $hasCheckedIn = Attendance::where('user_id', $schedule->user_id)
                ->whereDate('date', $today)
                ->exists();

            if (! $hasCheckedIn) {
                Attendance::create([
                    'user_id' => $schedule->user_id,
                    'date' => $today,
                    'status' => AttendanceStatus::ABSENT,
                    'verification_status' => AttendanceVerificationStatus::APPROVED,
                ]);
            }
        }

        $this->info('Absent employees marked successfully!');
    }
}
