<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:255'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required']
        ]);

        $user = User::create($attributes);

        return to_route('users.show', ['user' => $user])->with('success', 'User created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = $user->load([
            'schedules' => function ($query) {
                $query->orderBy('day'); // Sort schedules by the 'day' column
            }
        ]);

        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return response()->json($user->load(['schedules', 'attendances']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:255'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['required']
        ]);

        $user->update($attributes);

        return to_route('users.show', ['user' => $user])->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->schedules()->delete();

        $user->attendances()->delete();

        $user->delete();

        return to_route('users.index')->with('success', 'User deleted');
    }
}
