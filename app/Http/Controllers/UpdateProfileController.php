<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'photo' => [
                'nullable',
                'mimes:jpg,jpeg,png',
                File::image()
                    ->max(2 * 1024),
            ],
        ]);

        $user = $request->user();

        $attributes = $request->only(['name', 'email']);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profile', 'public');
            $attributes['photo'] = $path;
        }

        $user->update($attributes);

        return back()->with('success', 'Profile updated successfully');
    }
}
