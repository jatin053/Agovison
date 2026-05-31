<?php

namespace App\Policies;

use App\Models\Crop;
use App\Models\User;

class CropPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Farmer', 'Buyer', 'Expert']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Crop $crop): bool
    {
        return $crop->status === 'approved'
            || $user->hasRole('Admin')
            || $crop->user_id === $user->id
            || $user->hasRole('Expert');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Farmer']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Crop $crop): bool
    {
        return $user->hasRole('Admin') || ($user->hasRole('Farmer') && $crop->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Crop $crop): bool
    {
        return $this->update($user, $crop);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Crop $crop): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Crop $crop): bool
    {
        return $user->hasRole('Admin');
    }
}
