<?php

namespace App\Policies;

use App\Models\ExpertQuestion;
use App\Models\User;

class ExpertQuestionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Farmer', 'Expert']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExpertQuestion $expertQuestion): bool
    {
        return $user->hasRole('Admin')
            || $expertQuestion->user_id === $user->id
            || $expertQuestion->expert_id === $user->id
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
    public function update(User $user, ExpertQuestion $expertQuestion): bool
    {
        return $user->hasRole('Admin')
            || $expertQuestion->user_id === $user->id
            || $expertQuestion->expert_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExpertQuestion $expertQuestion): bool
    {
        return $user->hasRole('Admin') || $expertQuestion->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ExpertQuestion $expertQuestion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ExpertQuestion $expertQuestion): bool
    {
        return $user->hasRole('Admin');
    }
}
