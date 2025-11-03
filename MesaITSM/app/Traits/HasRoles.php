<?php

namespace App\Traits;

trait HasRoles
{
    /**
     * Check if the user has the given role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('administrador');
    }

    /**
     * Check if the user is a technician.
     *
     * @return bool
     */
    public function isTechnician(): bool
    {
        return $this->hasRole('tecnico');
    }

    /**
     * Check if the user is a regular user.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->hasRole('usuario');
    }
}