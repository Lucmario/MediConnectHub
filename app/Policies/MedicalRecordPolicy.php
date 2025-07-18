<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicalRecordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MedicalRecord $medicalRecord): bool
    {
        // Patient : accès à ses propres dossiers
        if ($user->role && $user->role->name === 'patient') {
            return $medicalRecord->patient && $medicalRecord->patient->user_id === $user->id;
        }
        // Médecin : accès à tous les dossiers (à adapter si besoin)
        if ($user->role && $user->role->name === 'doctor') {
            return true;
        }
        // Autres : pas d'accès
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MedicalRecord $medicalRecord): bool
    {
        // Même logique que view
        if ($user->role && $user->role->name === 'patient') {
            return $medicalRecord->patient && $medicalRecord->patient->user_id === $user->id;
        }
        if ($user->role && $user->role->name === 'doctor') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MedicalRecord $medicalRecord): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MedicalRecord $medicalRecord): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MedicalRecord $medicalRecord): bool
    {
        return false;
    }
}
