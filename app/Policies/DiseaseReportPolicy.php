<?php

namespace App\Policies;

use App\Models\DiseaseReport;
use App\Models\User;

class DiseaseReportPolicy
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
    public function view(User $user, DiseaseReport $diseaseReport): bool
    {
        return $user->hasRole('Admin')
            || $diseaseReport->user_id === $user->id
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
    public function update(User $user, DiseaseReport $diseaseReport): bool
    {
        return $user->hasRole('Admin') || $diseaseReport->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DiseaseReport $diseaseReport): bool
    {
        return $this->update($user, $diseaseReport);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DiseaseReport $diseaseReport): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DiseaseReport $diseaseReport): bool
    {
        return $user->hasRole('Admin');
    }
}
