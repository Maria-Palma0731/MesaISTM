<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role === 'administrador';
    }

    /**
     * Determine whether the user can toggle status.
     */
    public function toggleStatus(User $user, User $model): bool
    {
        // El administrador no puede desactivarse a sí mismo
        if ($user->id === $model->id) {
            return false;
        }

        return $user->role === 'administrador';
    }
}