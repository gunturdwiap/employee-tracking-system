<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'role' => UserRole::ADMIN
        ]);

        User::factory()->create([
            'name' => 'Clint Eastwood',
            'email' => 'user@user.user',
            'role' => UserRole::EMPLOYEE
        ]);

        $users = User::factory(10)->create();
        $attendances = Attendance::factory(10)->recycle($users)->create();
        $schedule = Schedule::factory(10)->recycle($users)->create();
    }
}
