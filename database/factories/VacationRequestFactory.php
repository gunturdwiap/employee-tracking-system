<?php

namespace Database\Factories;

use App\Enums\VacationRequestStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VacationRequest>
 */
class VacationRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start' => now()->addDays(10),
            'end' => now()->addDays(12),
            'status' => VacationRequestStatus::PENDING,
            'reason' => fake()->realText(),
            'user_id' => User::factory(),
        ];
    }
}
