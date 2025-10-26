<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link rel="stylesheet" href="/css/login.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="login-container">
        <form method="POST" action="{{ route('register.submit') }}" class="login-box">
            @csrf
            <h1>Crear cuenta</h1>

            @if($errors->any())
                <div class="errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <label for="name">Nombre</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>

            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>

            <label for="password_confirmation">Confirmar Contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>

            <button type="submit" class="btn">Registrar</button>

            <p style="margin-top:12px;font-size:14px;color:#6b7280">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
        </form>
    </div>
</body>
</html>
