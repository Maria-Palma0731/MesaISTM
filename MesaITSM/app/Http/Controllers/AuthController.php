<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'contrasena' => 'required'
        ]);

        $usuario = DB::table('usuarios')
            ->where('email', $request->email)
            ->where('activo', true)
            ->first();

        if ($usuario && Hash::check($request->contrasena, $usuario->contrasena)) {
            Session::put('usuario', [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'rol' => $usuario->rol
            ]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas o usuario inactivo']);
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'contrasena' => 'required|min:6',
            'rol' => 'required|in:admin,tecnico,usuario'
        ]);

        DB::table('usuarios')->insert([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contrasena' => Hash::make($request->contrasena),
            'rol' => $request->rol,
            'activo' => true,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now()
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso');
    }

    public function logout() {
        Session::forget('usuario');
        return redirect()->route('login');
    }
}
