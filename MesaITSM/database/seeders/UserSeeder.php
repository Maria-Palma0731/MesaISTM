<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== ADMINISTRADORES ====================
        User::create([
            'name' => 'Admin Usuario',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'administrador',
            'department' => 'IT',
            'is_active' => true
        ]);

        User::create([
            'name' => 'María García',
            'email' => 'maria.garcia@example.com',
            'password' => Hash::make('password'),
            'role' => 'administrador',
            'department' => 'IT',
            'is_active' => true
        ]);

        // ==================== TÉCNICOS ====================
        User::create([
            'name' => 'Técnico Usuario',
            'email' => 'tecnico@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
            'department' => 'Soporte',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Carlos Rodríguez',
            'email' => 'carlos.rodriguez@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
            'department' => 'Soporte',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Ana Martínez',
            'email' => 'ana.martinez@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
            'department' => 'Soporte',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Luis Fernández',
            'email' => 'luis.fernandez@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
            'department' => 'Redes',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Patricia López',
            'email' => 'patricia.lopez@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
            'department' => 'Hardware',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Roberto Sánchez',
            'email' => 'roberto.sanchez@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
            'department' => 'Software',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Sandra Moreno',
            'email' => 'sandra.moreno@example.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
            'department' => 'Seguridad',
            'is_active' => true
        ]);

        // ==================== USUARIOS NORMALES ====================
        User::create([
            'name' => 'Usuario Normal',
            'email' => 'usuario@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Ventas',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Ventas',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Laura Torres',
            'email' => 'laura.torres@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Marketing',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Pedro Ramírez',
            'email' => 'pedro.ramirez@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Contabilidad',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Sofia Jiménez',
            'email' => 'sofia.jimenez@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Recursos Humanos',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Diego Morales',
            'email' => 'diego.morales@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Operaciones',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Carmen Ruiz',
            'email' => 'carmen.ruiz@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Ventas',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Miguel Vargas',
            'email' => 'miguel.vargas@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Marketing',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Elena Castro',
            'email' => 'elena.castro@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Contabilidad',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Javier Ortiz',
            'email' => 'javier.ortiz@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Logística',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Isabel Navarro',
            'email' => 'isabel.navarro@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Recursos Humanos',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Fernando Díaz',
            'email' => 'fernando.diaz@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Operaciones',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Gabriela Herrera',
            'email' => 'gabriela.herrera@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Ventas',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Ricardo Mendoza',
            'email' => 'ricardo.mendoza@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Compras',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Valeria Silva',
            'email' => 'valeria.silva@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Finanzas',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Andrés Campos',
            'email' => 'andres.campos@example.com',
            'password' => Hash::make('password'),
            'role' => 'usuario',
            'department' => 'Producción',
            'is_active' => true
        ]);
    }
}