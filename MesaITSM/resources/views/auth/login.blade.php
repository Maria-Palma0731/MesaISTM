<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="/css/login.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="login-container">
        <form method="POST" action="{{ route('login.submit') }}" class="login-box">
            @csrf
            <h1>Iniciar sesión</h1>

            @if(session('status'))
                <div class="status" style="background:#ecfdf5;border:1px solid #bbf7d0;color:#064e3b;padding:10px;border-radius:8px;margin-bottom:8px">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>

            <div class="remember">
                <label><input type="checkbox" name="remember"> Recuérdame</label>
            </div>

            <button type="submit" class="btn">Entrar</button>

            <p style="margin-top:12px;font-size:14px;color:#6b7280">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
        </form>
    </div>
</body>
</html>
