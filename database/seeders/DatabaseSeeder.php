<?php

namespace Database\Seeders;

use App\Enums\Day;
use App\Enums\UserRole;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VacationRequest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.admin',
            'role' => UserRole::ADMIN,
        ]);

        User::factory()->create([
            'name' => 'verificator',
            'email' => 'verificator@verificator.verificator',
            'role' => UserRole::VERIFICATOR,
        ]);

        $orang = User::factory()->create([
            'name' => 'Louise Juventus Payong Bali Arakian',
            'email' => 'user@user.user',
            'role' => UserRole::EMPLOYEE,
        ]);

        $users = collect(User::factory(10)->create())->add($orang);

        // For each user, create schedules for each day of the week
        foreach ($users as $user) {
            foreach (Day::cases() as $day) {
                Schedule::factory()->create([
                    'user_id' => $user->id,
                    'day' => $day, // Assign each day to the 'day' column
                ]);
            }

            // Create random vacation requests for each user
            VacationRequest::factory(rand(1, 3))->create([
                'user_id' => $user->id,
                'start' => now()->subDay()->toDateString(), // 'Y-m-d' format
                'end' => now()->addDays(5)->toDateString(),  // 3 hours wasted cause sqlite ...
            ]);

            // Create random attendance records for each user
            // Attendance::factory(rand(0, 30))->create([
            //     'user_id' => $user->id,
            // ]);
        }
    }
}
