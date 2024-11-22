<?php

namespace App\Console\Commands;

use App\Enums\AttendanceStatus;
use App\Enums\VacationRequestStatus;
use App\Models\Attendance;
use App\Models\VacationRequest;
use Illuminate\Console\Command;

class UpdateVacationAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-vacation-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date
        $today = now()->format('Y-m-d');

        // Find all approved vacation requests that include today
        $vacationRequests = VacationRequest::where('status', VacationRequestStatus::APPROVED)
            ->whereDate('start', '<=', $today)
            ->whereDate('end', '>=', $today)
            ->get();

        foreach ($vacationRequests as $vacation) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $vacation->user_id,
                    'date' => $today,
                ],
                [
                    'status' => AttendanceStatus::VACATION, // Set attendance status to 'Vacation'
                    'check_in_time' => null, // Clear check-in and check-out times
                    'check_out_time' => null,
                    'photo' => null,
                ]
            );
        }
        $this->info('Attendance records updated for employees on vacation.');
        $this->info(count($vacationRequests) . ' updated');
    }
}
