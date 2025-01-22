<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users')->ignore($request->user()->id)],
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
