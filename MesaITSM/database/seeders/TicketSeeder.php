<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== TICKETS DE INCIDENTES ====================
        
        // Ticket 1 - Problema con correo electrónico
        Ticket::create([
            'title' => 'Problema con el correo electrónico',
            'description' => 'No puedo acceder a mi correo corporativo. Me aparece un error de autenticación cada vez que intento ingresar.',
            'category' => 'incidente',
            'subcategory' => 'software',
            'priority' => 'alta',
            'created_by' => 9, // Juan Pérez
            'assigned_to' => 3, // Técnico Usuario
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2)
        ]);

        // Ticket 2 - Error en sistema de ventas
        Ticket::create([
            'title' => 'Error en sistema de ventas',
            'description' => 'El sistema muestra error al generar reportes mensuales. Se queda cargando indefinidamente.',
            'category' => 'incidente',
            'subcategory' => 'software',
            'status' => 'en_proceso',
            'priority' => 'media',
            'created_by' => 14, // Carmen Ruiz
            'assigned_to' => 4, // Carlos Rodríguez
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(5)
        ]);

        // Ticket 3 - Computadora no enciende
        Ticket::create([
            'title' => 'Computadora no enciende',
            'description' => 'Mi computadora de escritorio no enciende desde esta mañana. No hace ningún sonido cuando presiono el botón de encendido.',
            'category' => 'incidente',
            'subcategory' => 'hardware',
            'status' => 'asignado',
            'priority' => 'alta',
            'created_by' => 10, // Laura Torres
            'assigned_to' => 7, // Patricia López
            'created_at' => Carbon::now()->subHours(5),
            'updated_at' => Carbon::now()->subHours(5)
        ]);

        // Ticket 4 - Internet lento
        Ticket::create([
            'title' => 'Conexión a internet muy lenta',
            'subject' => 'Conexión a internet muy lenta',
            'description' => 'La conexión a internet en mi área está extremadamente lenta. No puedo acceder a los sistemas en la nube.',
            'category' => 'incidente',
            'subcategory' => 'redes',
            'status' => 'en_proceso',
            'priority' => 'media',
            'created_by' => 11, // Pedro Ramírez
            'assigned_to' => 6, // Luis Fernández
            'department' => 'Contabilidad',
            'created_at' => Carbon::now()->subDays(1)
        ]);

        // Ticket 5 - Impresora no funciona
        Ticket::create([
            'title' => 'Impresora de red no responde',
            'subject' => 'Impresora de red no responde',
            'description' => 'La impresora del departamento no está imprimiendo. Todos los trabajos se quedan en cola.',
            'category' => 'incidente',
            'subcategory' => 'hardware',
            'status' => 'resuelto',
            'priority' => 'baja',
            'created_by' => 12, // Sofia Jiménez
            'assigned_to' => 7, // Patricia López
            'department' => 'Recursos Humanos',
            'created_at' => Carbon::now()->subDays(7),
            'closed_at' => Carbon::now()->subDays(6)
        ]);

        // Ticket 6 - Software se cierra solo
        Ticket::create([
            'title' => 'Software de contabilidad se cierra inesperadamente',
            'subject' => 'Software de contabilidad se cierra inesperadamente',
            'description' => 'El programa de contabilidad se cierra solo cada vez que intento generar un balance. He perdido información varias veces.',
            'category' => 'incidente',
            'subcategory' => 'software',
            'status' => 'pendiente_usuario',
            'priority' => 'alta',
            'created_by' => 16, // Elena Castro
            'assigned_to' => 8, // Roberto Sánchez
            'department' => 'Contabilidad',
            'created_at' => Carbon::now()->subDays(3)
        ]);

        // Ticket 7 - Acceso denegado
        Ticket::create([
            'title' => 'No puedo acceder a carpetas compartidas',
            'subject' => 'No puedo acceder a carpetas compartidas',
            'description' => 'Me aparece "Acceso denegado" cuando intento abrir las carpetas compartidas del servidor.',
            'category' => 'incidente',
            'subcategory' => 'redes',
            'status' => 'nuevo',
            'priority' => 'media',
            'created_by' => 13, // Diego Morales
            'assigned_to' => null,
            'department' => 'Operaciones',
            'created_at' => Carbon::now()->subHours(3)
        ]);

        // Ticket 8 - Pantalla parpadeante
        Ticket::create([
            'title' => 'Pantalla de monitor parpadea constantemente',
            'subject' => 'Pantalla de monitor parpadea constantemente',
            'description' => 'El monitor de mi computadora parpadea cada pocos segundos, es muy molesto para trabajar.',
            'category' => 'incidente',
            'subcategory' => 'hardware',
            'status' => 'asignado',
            'priority' => 'baja',
            'created_by' => 15, // Miguel Vargas
            'assigned_to' => 7, // Patricia López
            'department' => 'Marketing',
            'created_at' => Carbon::now()->subDays(1)
        ]);

        // ==================== TICKETS DE SOLICITUDES DE SERVICIO ====================

        // Ticket 9 - Solicitud de nuevo equipo
        Ticket::create([
            'title' => 'Solicitud de nuevo equipo',
            'subject' => 'Solicitud de nuevo equipo',
            'description' => 'Necesito un monitor adicional para mi trabajo. Actualmente trabajo con múltiples ventanas y un segundo monitor mejoraría mucho mi productividad.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'hardware',
            'status' => 'nuevo',
            'priority' => 'baja',
            'created_by' => 9, // Juan Pérez
            'assigned_to' => null,
            'department' => 'Ventas',
            'created_at' => Carbon::now()->subDays(4)
        ]);

        // Ticket 10 - Instalación de software
        Ticket::create([
            'title' => 'Instalación de software de diseño',
            'subject' => 'Instalación de software de diseño',
            'description' => 'Necesito que me instalen Adobe Photoshop y Adobe Illustrator para un proyecto nuevo.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'software',
            'status' => 'en_proceso',
            'priority' => 'media',
            'created_by' => 10, // Laura Torres
            'assigned_to' => 8, // Roberto Sánchez
            'department' => 'Marketing',
            'created_at' => Carbon::now()->subDays(3)
        ]);

        // Ticket 11 - Creación de usuario
        Ticket::create([
            'title' => 'Alta de nuevo empleado en el sistema',
            'subject' => 'Alta de nuevo empleado en el sistema',
            'description' => 'Solicito crear un usuario para el nuevo empleado que ingresa mañana: María González del departamento de Ventas.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'accesos',
            'status' => 'resuelto',
            'priority' => 'alta',
            'created_by' => 12, // Sofia Jiménez
            'assigned_to' => 3, // Técnico Usuario
            'department' => 'Recursos Humanos',
            'created_at' => Carbon::now()->subDays(5),
            'closed_at' => Carbon::now()->subDays(4)
        ]);

        // Ticket 12 - Configuración de teléfono
        Ticket::create([
            'title' => 'Configuración de extensión telefónica',
            'subject' => 'Configuración de extensión telefónica',
            'description' => 'Me cambiaron de oficina y necesito que configuren mi extensión telefónica en la nueva ubicación.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'telecomunicaciones',
            'status' => 'asignado',
            'priority' => 'media',
            'created_by' => 17, // Javier Ortiz
            'assigned_to' => 6, // Luis Fernández
            'department' => 'Logística',
            'created_at' => Carbon::now()->subDays(2)
        ]);

        // Ticket 13 - Solicitud de licencia
        Ticket::create([
            'title' => 'Renovación de licencia de antivirus',
            'subject' => 'Renovación de licencia de antivirus',
            'description' => 'Mi licencia de antivirus está por vencer. Solicito su renovación.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'software',
            'status' => 'nuevo',
            'priority' => 'baja',
            'created_by' => 20, // Ricardo Mendoza
            'assigned_to' => null,
            'department' => 'Compras',
            'created_at' => Carbon::now()->subDays(1)
        ]);

        // Ticket 14 - Acceso remoto
        Ticket::create([
            'title' => 'Configuración de acceso remoto VPN',
            'subject' => 'Configuración de acceso remoto VPN',
            'description' => 'Necesito acceso remoto VPN para trabajar desde casa la próxima semana.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'redes',
            'status' => 'en_proceso',
            'priority' => 'alta',
            'created_by' => 14, // Carmen Ruiz
            'assigned_to' => 6, // Luis Fernández
            'department' => 'Ventas',
            'created_at' => Carbon::now()->subDays(2)
        ]);

        // Ticket 15 - Backup de datos
        Ticket::create([
            'title' => 'Respaldo de información del servidor',
            'subject' => 'Respaldo de información del servidor',
            'description' => 'Solicito un respaldo completo de la información de mi área antes de la migración del sistema.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'respaldo',
            'status' => 'nuevo',
            'priority' => 'alta',
            'created_by' => 18, // Isabel Navarro
            'assigned_to' => null,
            'department' => 'Recursos Humanos',
            'created_at' => Carbon::now()->subHours(8)
        ]);

        // Ticket 16 - Cambio de contraseña
        Ticket::create([
            'title' => 'Restablecimiento de contraseña',
            'subject' => 'Restablecimiento de contraseña',
            'description' => 'Olvidé mi contraseña del sistema y no puedo acceder. Solicito su restablecimiento.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'accesos',
            'status' => 'resuelto',
            'priority' => 'alta',
            'created_by' => 19, // Fernando Díaz
            'assigned_to' => 4, // Carlos Rodríguez
            'department' => 'Operaciones',
            'created_at' => Carbon::now()->subHours(12),
            'closed_at' => Carbon::now()->subHours(11)
        ]);

        // Ticket 17 - Mantenimiento preventivo
        Ticket::create([
            'title' => 'Mantenimiento preventivo de equipo',
            'subject' => 'Mantenimiento preventivo de equipo',
            'description' => 'Mi computadora está muy lenta y no se le ha dado mantenimiento en más de un año. Solicito mantenimiento preventivo.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'hardware',
            'status' => 'pendiente_usuario',
            'priority' => 'baja',
            'created_by' => 11, // Pedro Ramírez
            'assigned_to' => 7, // Patricia López
            'department' => 'Contabilidad',
            'created_at' => Carbon::now()->subDays(6)
        ]);

        // Ticket 18 - Capacitación
        Ticket::create([
            'title' => 'Capacitación en nuevo sistema ERP',
            'subject' => 'Capacitación en nuevo sistema ERP',
            'description' => 'Solicito capacitación para el uso del nuevo sistema ERP que se implementará el próximo mes.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'capacitacion',
            'status' => 'asignado',
            'priority' => 'media',
            'created_by' => 16, // Elena Castro
            'assigned_to' => 5, // Ana Martínez
            'department' => 'Contabilidad',
            'created_at' => Carbon::now()->subDays(8)
        ]);

        // Ticket 19 - Transferencia de archivos
        Ticket::create([
            'title' => 'Transferencia de archivos grandes',
            'subject' => 'Transferencia de archivos grandes',
            'description' => 'Necesito ayuda para transferir archivos grandes (más de 5GB) a un cliente. El email no me permite enviarlos.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'software',
            'status' => 'nuevo',
            'priority' => 'media',
            'created_by' => 15, // Miguel Vargas
            'assigned_to' => null,
            'department' => 'Marketing',
            'created_at' => Carbon::now()->subHours(6)
        ]);

        // Ticket 20 - Configuración de correo en móvil
        Ticket::create([
            'title' => 'Configuración de correo corporativo en celular',
            'subject' => 'Configuración de correo corporativo en celular',
            'description' => 'Necesito configurar mi correo corporativo en mi celular nuevo para poder revisar correos fuera de la oficina.',
            'category' => 'solicitud_servicio',
            'subcategory' => 'software',
            'status' => 'resuelto',
            'priority' => 'baja',
            'created_by' => 13, // Diego Morales
            'assigned_to' => 4, // Carlos Rodríguez
            'department' => 'Operaciones',
            'created_at' => Carbon::now()->subDays(4),
            'closed_at' => Carbon::now()->subDays(4)
        ]);
    }
}