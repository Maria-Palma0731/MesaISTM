<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
<h2>Bienvenida, {{ session('usuario.nombre') }}</h2>
<p>Rol: {{ session('usuario.rol') }}</p>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>
</body>
</html>
