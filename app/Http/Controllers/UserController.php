<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::query();

        $request->validate([
            's' => ['nullable', 'string'],
            'role' => ['nullable', 'array'],
        ]);

        // Apply role filter if provided
        if ($request->filled('role')) {
            $user->whereIn('role', $request->role);
        }

        // Apply search filter
        if ($request->filled('s')) {
            $user->where(function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->s.'%')
                    ->orWhere('email', 'like', '%'.$request->s.'%');
            });
        }

        return view('users.index', [
            'users' => $user->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:255'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'password' => ['required', 'confirmed', Password::default()],
        ]);

        User::create($attributes);

        return to_route('users.index')->with('success', 'User created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = $user->load([
            'schedules' => function (Builder $query) {
                $query->orderBy('day');
            },
        ]);

        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:255'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id), 'max:255'],
        ]);

        $user->fill($attributes);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return to_route('users.edit', ['user' => $user])->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role == UserRole::ADMIN) {
            return to_route('users.index')->with('danger', 'Cant delete user with admin role');
        }

        $user->schedules()->delete();

        $user->attendances()->delete();

        $user->delete();

        return to_route('users.index')->with('success', 'User deleted');
    }
}
