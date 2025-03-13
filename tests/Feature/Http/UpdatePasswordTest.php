<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('can update user password', function () {
    $user = User::factory()->create(['password' => Hash::make('password')])->fresh();

    $response = $this->actingAs($user)
        ->put(route('update-password'), [
            'password' => 'password',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success');
    expect(Hash::check('new_password', $user->fresh()->password))->toBeTrue();
});

it('cant update user password if the old password is incorrect', function () {
    $user = User::factory()->create(['password' => Hash::make('password')])->fresh();

    $response = $this->actingAs($user)
        ->put(route('update-password'), [
            'password' => 'idkman',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ]);

    $response->assertRedirect()
        ->assertSessionHasErrors();
    expect(Hash::check('new_password', $user->fresh()->password))->toBeFalse();
});
