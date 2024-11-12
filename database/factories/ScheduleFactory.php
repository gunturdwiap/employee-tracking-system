<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'work_start_time' => now(),
            'work_end_time' => now()->addHours(8),
            'day' => rand(1, 7),
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'radius' => rand(100, 500),
            'user_id' => User::factory()
        ];
    }
}
