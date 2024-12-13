<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\VacationRequest;
use Illuminate\Auth\Access\Response;

class VacationRequestPolicy
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
    public function view(User $user, VacationRequest $vacationRequest): bool
    {
        return ($user->role === UserRole::ADMIN) || ($user->role === UserRole::VERIFICATOR) || ($user->id === $vacationRequest->user_id);
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
        return ($user->role === UserRole::ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return ($user->role === UserRole::ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return ($user->role === UserRole::ADMIN);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return ($user->role === UserRole::ADMIN);
    }

    public function updateStatus(User $user): bool
    {
        return ($user->role === UserRole::ADMIN) || ($user->role === UserRole::VERIFICATOR);
    }
}
