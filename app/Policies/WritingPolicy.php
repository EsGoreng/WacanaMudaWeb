<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Writing;

class WritingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'member']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Writing $writing): bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return $writing->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['superadmin', 'admin', 'member']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Writing $writing): bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return $writing->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Writing $writing): bool
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }

        return $writing->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Writing $writing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Writing $writing): bool
    {
        return false;
    }
}
