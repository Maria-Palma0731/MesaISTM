<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mesa de Ayuda')</title>
    <link rel="stylesheet" href="/css/tickets.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1 class="logo">Mesa de Ayuda ITSM</h1>
            <nav>
                <a href="/dashboard">Dashboard</a>
                <a href="/tickets">Tickets</a>
                <a href="/logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            </nav>
        </div>
    </header>
    <main class="container">
        @yield('content')
    </main>
</body>
</html>
