<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can update user profile', function () {
    Storage::fake('public');
    $user = User::factory()->create()->fresh();
    $file = UploadedFile::fake()->image('photo.jpg');

    $response = $this->actingAs($user)
        ->put(route('update-profile'), [
            'name' => 'John Genshin',
            'email' => 'john@genshin.com',
            'photo' => $file,
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success');

    Storage::disk('public')->assertExists('profile/'.$file->hashName());

    $user->fresh();
    expect($user->name)->toBe('John Genshin')
        ->and($user->email)->toBe('john@genshin.com')
        ->and($user->photo)->toBe('profile/'.$file->hashName());
});

it('doesnt update the photo if not provided', function () {
    $user = User::factory()->create()->fresh();

    $response = $this->actingAs($user)
        ->put(route('update-profile'), [
            'name' => 'John Genshin',
            'email' => 'john@genshin.com',
            'photo' => null,
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success');

    $user->fresh();
    expect($user->name)->toBe('John Genshin')
        ->and($user->email)->toBe('john@genshin.com')
        ->and($user->photo)->toBeNull();
});

test('user must verify email again if email is updated', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'email' => 'jojo@gmail.com',
    ])->fresh();

    $response = $this->actingAs($user)
        ->put(route('update-profile'), [
            'name' => 'John Genshin',
            'email' => 'johngenshin@gmail.com',
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success');

    $user->refresh();
    expect($user->email_verified_at)->toBeNull();
});

it('deletes old photo when new photo uploaded', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'photo' => UploadedFile::fake()->image('avatar.jpg')->store('profile', 'public'),
    ])->fresh();
    $oldPhoto = $user->photo;
    $file = UploadedFile::fake()->image('photo.jpg');

    $response = $this->actingAs($user)
        ->put(route('update-profile'), [
            'name' => 'John Genshin',
            'email' => 'john@john.john',
            'photo' => $file,
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success');

    Storage::disk('public')->assertExists('profile/'.$file->hashName());
    Storage::disk('public')->assertMissing($oldPhoto);

    $user->fresh();
    expect($user->photo)->toBe('profile/'.$file->hashName());
});
