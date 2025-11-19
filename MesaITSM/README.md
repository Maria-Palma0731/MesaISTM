# Sistema de Mesa de Ayuda - Catálogo de Servicios

## Descripción
Este es un sistema de Mesa de Ayuda (Help Desk) desarrollado con Laravel que incluye un completo catálogo de servicios de TI. Permite a los usuarios solicitar servicios de soporte técnico de manera organizada y a los administradores gestionar eficientemente las solicitudes.

## Características Principales

### Catálogo de Servicios
- Organización por categorías (Hardware, Software, Redes, etc.)
- Formularios dinámicos para cada tipo de servicio
- Tiempos estimados de atención
- Prioridades predefinidas
- Asignación automática por departamento

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

### Panel de Administración
- Gestión de categorías de servicios
- Creación y edición de servicios
- Configuración de formularios dinámicos
- Ordenamiento mediante drag & drop
- Estadísticas y reportes

### Interfaz de Usuario
- Catálogo intuitivo y responsive
- Formularios personalizados por servicio
- Seguimiento de solicitudes
- Notificaciones de estado

## Requisitos Técnicos

- PHP >= 8.2
- Composer
- Node.js y NPM
- Base de datos MySQL o PostgreSQL
- Laravel 11.x

## Instalación

1. Clonar el repositorio
```bash
git clone [url-del-repositorio]
```

2. Instalar dependencias de PHP
```bash
composer install
```

3. Instalar dependencias de JavaScript
```bash
npm install
```

4. Configurar el archivo .env
```bash
cp .env.example .env
php artisan key:generate
```

5. Configurar la base de datos en el archivo .env

6. Ejecutar las migraciones y seeders
```bash
php artisan migrate --seed
```

7. Compilar los assets
```bash
npm run dev
```

8. Iniciar el servidor
```bash
php artisan serve
```

## Datos de Prueba

El sistema incluye seeders con datos de ejemplo para probar las funcionalidades:

### Categorías de Servicios
- Hardware
- Software
- Redes
- Seguridad
- Correo Electrónico

### Servicios Preconfigurados
1. Mantenimiento de Computadora
2. Instalación de Periféricos
3. Instalación de Software
4. Conexión a Red
5. Análisis de Virus
6. Configuración de Correo

## Uso del Sistema

### Usuarios
1. Navegar por el catálogo de servicios
2. Seleccionar el servicio requerido
3. Completar el formulario específico
4. Enviar la solicitud
5. Dar seguimiento al estado

### Administradores
1. Gestionar categorías y servicios
2. Configurar formularios
3. Procesar solicitudes
4. Generar reportes

## Estado Actual del Proyecto

El sistema se encuentra en fase de desarrollo con las siguientes funcionalidades implementadas:

✅ Estructura base del proyecto
✅ Migraciones de base de datos
✅ Modelos con relaciones
✅ Controladores principales
✅ Vistas del catálogo
✅ Sistema de formularios dinámicos
✅ Seeders con datos de prueba

## Próximas Actualizaciones

- Sistema de notificaciones
- API REST
- Integración con Active Directory
- Reportes avanzados
- Panel de métricas

## Licencia
Este proyecto está bajo la Licencia MIT. Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
