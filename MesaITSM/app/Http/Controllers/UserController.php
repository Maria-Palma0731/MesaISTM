<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Aplicar filtros
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $users = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Obtener departamentos únicos para el filtro
        $departments = User::distinct()
            ->whereNotNull('department')
            ->pluck('department');

        return view('admin.users.index', compact('users', 'departments'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('administrador.users.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // Si solo se está actualizando el estado (is_active)
        if ($request->has('is_active') && count($request->all()) <= 3) { // _token, _method, is_active
            $user->update(['is_active' => $request->boolean('is_active')]);
            
            return redirect()
                ->route('administrador.users.index')
                ->with('success', 'Estado del usuario actualizado exitosamente');
        }

        // Actualización completa del usuario
        $validated = $request->validated();

        // Solo actualizar la contraseña si se proporcionó una nueva
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('administrador.users.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // No permitir eliminar el propio usuario
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('administrador.users.index')
                ->with('error', 'No puedes eliminar tu propio usuario');
        }

        $user->delete();

        return redirect()
            ->route('administrador.users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }

    /**
     * Toggle the status of the specified user.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        // Solo administradores pueden cambiar el estado
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'No autorizado');
        }

        $user->update(['is_active' => !$user->is_active]);

        return redirect()
            ->route('administrador.users.index')
            ->with('success', 'Estado del usuario actualizado exitosamente');
    }
}