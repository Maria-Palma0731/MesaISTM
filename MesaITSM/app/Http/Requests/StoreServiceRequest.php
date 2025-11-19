<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'administrador';
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:service_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:50'],
            'estimated_time' => ['required', 'string', 'max:100'],
            'form_fields' => ['required', 'json'],
            'department' => ['required', 'string', 'max:100'],
            'priority_default' => ['required', 'in:baja,media,alta,critica'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer']
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'categoría',
            'name' => 'nombre',
            'description' => 'descripción',
            'icon' => 'icono',
            'estimated_time' => 'tiempo estimado',
            'form_fields' => 'campos del formulario',
            'department' => 'departamento',
            'priority_default' => 'prioridad por defecto',
            'is_active' => 'activo',
            'order' => 'orden'
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('form_fields') && is_array($this->form_fields)) {
            $this->merge([
                'form_fields' => json_encode($this->form_fields)
            ]);
        }
    }
}