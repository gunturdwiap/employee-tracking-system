<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class AttendancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ($user->role === UserRole::ADMIN) || ($user->role === UserRole::VERIFICATOR);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return ($user->role === UserRole::ADMIN) || ($user->role === UserRole::VERIFICATOR);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return ($user->role === UserRole::ADMIN) || ($user->role === UserRole::EMPLOYEE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function verify(User $user)
    {
        return ($user->role === UserRole::ADMIN) || ($user->role === UserRole::VERIFICATOR);
    }
}
