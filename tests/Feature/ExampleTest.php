<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $user = User::factory()->create();

        $user->update(['role' => UserRole::ADMIN]);

        $this->assertSame(UserRole::ADMIN, $user->fresh()->role);

    }
}
