<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Hardware
            [
                'category_id' => 1,
                'name' => 'Mantenimiento de Computadora',
                'description' => 'Servicio de mantenimiento preventivo y correctivo de equipos de cómputo',
                'estimated_time' => '2-3 horas',
                'department' => 'Soporte Técnico',
                'priority_default' => 'media',
                'form_fields' => json_encode([
                    [
                        'type' => 'text',
                        'name' => 'numero_inventario',
                        'label' => 'Número de Inventario',
                        'required' => true,
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'descripcion_problema',
                        'label' => 'Descripción del Problema',
                        'required' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'tipo_mantenimiento',
                        'label' => 'Tipo de Mantenimiento',
                        'options' => ['Preventivo', 'Correctivo'],
                        'required' => true,
                    ],
                ]),
            ],
            [
                'category_id' => 1,
                'name' => 'Instalación de Periféricos',
                'description' => 'Instalación y configuración de impresoras, escáneres y otros periféricos',
                'estimated_time' => '1 hora',
                'department' => 'Soporte Técnico',
                'priority_default' => 'baja',
                'form_fields' => json_encode([
                    [
                        'type' => 'text',
                        'name' => 'modelo_dispositivo',
                        'label' => 'Modelo del Dispositivo',
                        'required' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'tipo_dispositivo',
                        'label' => 'Tipo de Dispositivo',
                        'options' => ['Impresora', 'Escáner', 'Monitor', 'Otro'],
                        'required' => true,
                    ],
                ]),
            ],

            // Software
            [
                'category_id' => 2,
                'name' => 'Instalación de Software',
                'description' => 'Instalación y configuración de programas autorizados',
                'estimated_time' => '1-2 horas',
                'department' => 'Soporte Técnico',
                'priority_default' => 'media',
                'form_fields' => json_encode([
                    [
                        'type' => 'text',
                        'name' => 'software_requerido',
                        'label' => 'Software Requerido',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'version',
                        'label' => 'Versión',
                        'required' => true,
                    ],
                ]),
            ],

            // Redes
            [
                'category_id' => 3,
                'name' => 'Conexión a Red',
                'description' => 'Configuración de acceso a red corporativa',
                'estimated_time' => '30 minutos',
                'department' => 'Redes',
                'priority_default' => 'alta',
                'form_fields' => json_encode([
                    [
                        'type' => 'text',
                        'name' => 'ubicacion',
                        'label' => 'Ubicación',
                        'required' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'tipo_conexion',
                        'label' => 'Tipo de Conexión',
                        'options' => ['Alámbrica', 'Inalámbrica'],
                        'required' => true,
                    ],
                ]),
            ],

            // Seguridad
            [
                'category_id' => 4,
                'name' => 'Análisis de Virus',
                'description' => 'Escaneo y eliminación de malware',
                'estimated_time' => '2-4 horas',
                'department' => 'Seguridad IT',
                'priority_default' => 'alta',
                'form_fields' => json_encode([
                    [
                        'type' => 'textarea',
                        'name' => 'sintomas',
                        'label' => 'Síntomas Observados',
                        'required' => true,
                    ],
                    [
                        'type' => 'checkbox',
                        'name' => 'respaldo',
                        'label' => '¿Tiene respaldo de su información?',
                        'required' => false,
                    ],
                ]),
            ],

            // Correo Electrónico
            [
                'category_id' => 5,
                'name' => 'Configuración de Correo',
                'description' => 'Configuración de cliente de correo electrónico',
                'estimated_time' => '30 minutos',
                'department' => 'Soporte Técnico',
                'priority_default' => 'media',
                'form_fields' => json_encode([
                    [
                        'type' => 'email',
                        'name' => 'correo',
                        'label' => 'Dirección de Correo',
                        'required' => true,
                    ],
                    [
                        'type' => 'select',
                        'name' => 'cliente_correo',
                        'label' => 'Cliente de Correo',
                        'options' => ['Outlook', 'Thunderbird', 'Otro'],
                        'required' => true,
                    ],
                ]),
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}