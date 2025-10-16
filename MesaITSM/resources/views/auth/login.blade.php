<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Iniciar sesión</h2>
@if ($errors->any())
    <div>{{ $errors->first() }}</div>
@endif
<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="Correo" required><br>
    <input type="password" name="contrasena" placeholder="Contraseña" required><br>
    <button type="submit">Entrar</button>
</form>
<a href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
</body>
</html>

