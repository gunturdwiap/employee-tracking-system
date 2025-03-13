<?php

namespace Database\Factories;

use App\Enums\AttendanceStatus;
use App\Enums\AttendanceVerificationStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => now()->subDays(rand(0, 30))->toDateString(),
            'check_in_time' => now(),
            'check_out_time' => now()->addHours(8),
            'status' => rand(0, 1) === 1 ? AttendanceStatus::LATE : AttendanceStatus::ON_TIME,
            'verification_status' => AttendanceVerificationStatus::PENDING,
            'user_id' => User::factory(),
        ];
    }
}
