<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'administrador';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:50'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer']
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'icon' => 'icono',
            'is_active' => 'activo',
            'order' => 'orden'
        ];
    }
}