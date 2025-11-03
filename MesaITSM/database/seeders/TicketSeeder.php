<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // Crear algunos tickets de prueba
        Ticket::create([
            'title' => 'Problema con el correo electrónico',
            'subject' => 'Problema con el correo electrónico',
            'description' => 'No puedo acceder a mi correo corporativo',
            'category' => 'incidente',
            'subcategory' => 'software',
            'status' => 'nuevo',
            'priority' => 'alta',
            'created_by' => 3, // Usuario normal
            'assigned_to' => 2, // Técnico
            'department' => 'IT'
        ]);

        Ticket::create([
            'title' => 'Error en sistema de ventas',
            'subject' => 'Error en sistema de ventas',
            'description' => 'El sistema muestra error al generar reportes',
            'category' => 'incidente',
            'subcategory' => 'software',
            'status' => 'en_proceso',
            'priority' => 'media',
            'created_by' => 3, // Usuario normal
            'assigned_to' => 2, // Técnico
            'department' => 'Ventas'
        ]);

        Ticket::create([
            'title' => 'Solicitud de nuevo equipo',
            'subject' => 'Solicitud de nuevo equipo',
            'description' => 'Necesito un monitor adicional para mi trabajo',
            'category' => 'solicitud_servicio',
            'subcategory' => 'hardware',
            'status' => 'nuevo',
            'priority' => 'baja',
            'created_by' => 3, // Usuario normal
            'department' => 'Ventas'
        ]);
    }
}