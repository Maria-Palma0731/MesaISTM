<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'name' => 'Admin Usuario',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'administrador',
            'department' => 'IT',
            'is_active' => true
        ]);

        // Usuario Técnico
        User::create([
            'name' => 'Técnico Usuario',
            'email' => 'tecnico@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
            'department' => 'Soporte',
            'is_active' => true
        ]);

        // Usuario Normal
        User::create([
            'name' => 'Usuario Normal',
            'email' => 'usuario@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Ventas',
            'is_active' => true
        ]);
    }
}