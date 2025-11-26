<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeArticle;
use Carbon\Carbon;
use Illuminate\Support\Str;

class KnowledgeArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            // ==================== GUÍAS Y TUTORIALES ====================
            [
                'title' => 'Cómo crear un nuevo ticket de soporte',
                'slug' => 'como-crear-un-nuevo-ticket-de-soporte',
                'category' => 'guias',
                'summary' => 'Guía paso a paso para crear y enviar un ticket de soporte técnico en el sistema.',
                'content' => "# Cómo crear un nuevo ticket de soporte\n\n## Introducción\nEsta guía te ayudará a crear un ticket de soporte de manera efectiva.\n\n## Pasos a seguir\n\n### 1. Acceder al sistema\n- Inicia sesión con tus credenciales\n- Ve al menú principal\n\n### 2. Crear nuevo ticket\n- Haz clic en \"Nuevo Ticket\"\n- Selecciona la categoría apropiada\n- Describe tu problema claramente\n\n### 3. Información importante\n- **Título**: Sé específico y claro\n- **Descripción**: Incluye todos los detalles relevantes\n- **Prioridad**: Selecciona según la urgencia\n- **Archivos**: Adjunta capturas de pantalla si es necesario\n\n## Consejos\n- Proporciona el máximo de información posible\n- Incluye mensajes de error si los hay\n- Describe los pasos que llevaron al problema",
                'tags' => 'tickets,soporte,crear,tutorial',
                'is_published' => true,
                'views' => 45,
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Guía de uso del catálogo de servicios',
                'category' => 'guias',
                'summary' => 'Aprende a navegar y solicitar servicios desde el catálogo de servicios de TI.',
                'content' => "# Guía del Catálogo de Servicios\n\nEs una plataforma centralizada donde puedes encontrar y solicitar todos los servicios de TI disponibles.\n\n## Navegación\n\n### Explorar categorías\n1. Accede desde el menú \"Catálogo de Servicios\"\n2. Explora las categorías: Hardware, Software, Redes, Seguridad\n\n### Solicitar un servicio\n1. Selecciona el servicio deseado\n2. Lee la descripción y requisitos\n3. Completa el formulario\n4. Envía tu solicitud",
                'tags' => 'catalogo,servicios,solicitudes,tutorial',
                'is_published' => true,
                'views' => 67,
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Cómo cambiar tu contraseña',
                'category' => 'guias',
                'summary' => 'Instrucciones para cambiar tu contraseña de manera segura.',
                'content' => "# Cambio de Contraseña\n\n## Acceso al perfil\n1. Haz clic en tu nombre en la esquina superior\n2. Selecciona \"Perfil\"\n3. Ve a \"Seguridad\"\n\n## Requisitos\n- Mínimo 8 caracteres\n- Una mayúscula\n- Un número\n- Un carácter especial\n\n## Consejos\n- No compartas tu contraseña\n- Cámbiala cada 90 días",
                'tags' => 'contraseña,seguridad,perfil',
                'is_published' => true,
                'views' => 123,
                'created_by' => 2,
                'created_at' => Carbon::now()->subDays(10),
            ],
            
            // ==================== FAQ ====================
            [
                'title' => '¿Cómo resetear mi contraseña?',
                'category' => 'faq',
                'summary' => 'Solución rápida para recuperar acceso a tu cuenta.',
                'content' => "# Reseteo de Contraseña\n\n1. Ve a la página de login\n2. Clic en \"Olvidé mi contraseña\"\n3. Ingresa tu correo\n4. Sigue el enlace recibido\n\nEl enlace expira en 60 minutos.",
                'tags' => 'contraseña,login,acceso',
                'is_published' => true,
                'views' => 89,
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'title' => '¿Cuánto tarda en resolverse un ticket?',
                'category' => 'faq',
                'summary' => 'Tiempos de respuesta según prioridad.',
                'content' => "# Tiempos de Resolución\n\n## Crítica\n- Respuesta: 1 hora\n- Resolución: 4 horas\n\n## Alta\n- Respuesta: 4 horas\n- Resolución: 24 horas\n\n## Media\n- Respuesta: 8 horas\n- Resolución: 3 días\n\n## Baja\n- Respuesta: 24 horas\n- Resolución: 5 días",
                'tags' => 'tickets,tiempo,sla',
                'is_published' => true,
                'views' => 156,
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(18),
            ],
            [
                'title' => '¿Cómo contactar a soporte?',
                'category' => 'faq',
                'summary' => 'Canales disponibles para contactar soporte.',
                'content' => "# Contacto con Soporte\n\n## Sistema de Tickets\nMétodo recomendado\n\n## Email\nsoporte@empresa.com\n\n## Teléfono\nExt. 2000 (8AM-6PM)\n\n## Emergencias\nExt. 2001 (24/7)",
                'tags' => 'soporte,contacto,ayuda',
                'is_published' => true,
                'views' => 78,
                'created_by' => 2,
                'created_at' => Carbon::now()->subDays(12),
            ],
            
            // ==================== TÉCNICA ====================
            [
                'title' => 'Configuración de VPN',
                'category' => 'tecnica',
                'summary' => 'Guía técnica para configurar VPN corporativa.',
                'content' => "# VPN Corporativa\n\n## Requisitos\n- Cliente VPN instalado\n- Credenciales aprobadas\n\n## Configuración Windows\nServidor: vpn.empresa.com\nPuerto: 443\nProtocolo: IKEv2\n\n## Conexión\n1. Abre cliente VPN\n2. Ingresa credenciales\n3. Conectar\n\n## Problemas comunes\n- Verifica internet\n- Confirma credenciales\n- Revisa firewall",
                'tags' => 'vpn,remoto,conexion',
                'is_published' => true,
                'views' => 234,
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'title' => 'Especificaciones de equipos',
                'category' => 'tecnica',
                'summary' => 'Hardware estándar proporcionado.',
                'content' => "# Equipos Estándar\n\n## Desktop Estándar\n- i5 11th Gen\n- 16GB RAM\n- 512GB SSD\n- Windows 11 Pro\n- Monitor 24\"\n\n## Desktop Avanzado\n- i7 12th Gen\n- 32GB RAM\n- 1TB SSD\n- RTX 3060\n- Monitor 27\" 4K\n\n## Laptop\n- Dell Latitude 5420\n- i5/16GB/512GB\n- Pantalla 14\" FHD",
                'tags' => 'hardware,equipos,especificaciones',
                'is_published' => true,
                'views' => 145,
                'created_by' => 2,
                'created_at' => Carbon::now()->subDays(22),
            ],
            
            // ==================== POLÍTICAS ====================
            [
                'title' => 'Políticas de seguridad',
                'category' => 'politicas',
                'summary' => 'Normativas de seguridad de información.',
                'content' => "# Seguridad de Información\n\n## Contraseñas\n- 12 caracteres mínimo\n- Cambio cada 90 días\n- No compartir\n\n## Correo\n- Uso profesional\n- No cadenas\n- Reportar phishing\n\n## Datos\n- Encriptar confidenciales\n- No USB desconocidos\n- Bloquear pantalla\n\n## Incidentes\nReportar: seguridad@empresa.com",
                'tags' => 'seguridad,politicas,normativa',
                'is_published' => true,
                'views' => 312,
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(45),
            ],
            [
                'title' => 'Uso aceptable de TI',
                'category' => 'politicas',
                'summary' => 'Directrices de uso de recursos TI.',
                'content' => "# Uso Aceptable\n\n## Permitido\n- Trabajo\n- Capacitación\n- Uso personal mínimo\n\n## Prohibido\n- Contenido ilegal\n- Software pirata\n- Sitios inapropiados\n- Minería cripto\n\n## Software\n- Solo aprobado por TI\n- Licencias válidas\n- Actualizar siempre\n\n## Sanciones\n1. Advertencia\n2. Amonestación\n3. Suspensión\n4. Terminación",
                'tags' => 'politicas,uso,normativa',
                'is_published' => true,
                'views' => 267,
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(35),
            ],
        ];

        foreach ($articles as $article) {
            // Auto-generate slug if not provided
            if (!isset($article['slug'])) {
                $article['slug'] = Str::slug($article['title']);
            }
            KnowledgeArticle::create($article);
        }
    }
}
