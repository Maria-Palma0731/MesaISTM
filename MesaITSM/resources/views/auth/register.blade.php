<!DOCTYPE html>
<html>
<head><title>Registro</title></head>
<body>
<h2>Crear cuenta</h2>
@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="text" name="nombre" placeholder="Nombre completo" required><br>
    <input type="email" name="email" placeholder="Correo" required><br>
    <input type="password" name="contrasena" placeholder="Contraseña" required><br>
    <select name="rol" required>
        <option value="usuario">Usuario</option>
        <option value="tecnico">Técnico</option>
        <option value="admin">Administrador</option>
    </select><br>
    <button type="submit">Registrarse</button>
</form>
<a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a>
</body>
</html>
