<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hardware',
                'description' => 'Servicios relacionados con equipos físicos y periféricos',
                'icon' => 'computer-desktop',
                'order' => 1,
            ],
            [
                'name' => 'Software',
                'description' => 'Servicios de instalación y soporte de aplicaciones',
                'icon' => 'cog',
                'order' => 2,
            ],
            [
                'name' => 'Redes',
                'description' => 'Servicios de conectividad y redes',
                'icon' => 'signal',
                'order' => 3,
            ],
            [
                'name' => 'Seguridad',
                'description' => 'Servicios de seguridad informática',
                'icon' => 'shield-check',
                'order' => 4,
            ],
            [
                'name' => 'Correo Electrónico',
                'description' => 'Gestión de cuentas y soporte de correo electrónico',
                'icon' => 'envelope',
                'order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}