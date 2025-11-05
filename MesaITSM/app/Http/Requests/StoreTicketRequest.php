<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cualquier usuario autenticado puede crear tickets
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:10', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'category' => ['required', 'string', 'in:incidente,solicitud_servicio'],
            'subcategory' => ['required', 'string', 'in:hardware,software,red,accesos,otro'],
            'priority' => ['required', 'string', 'in:baja,media,alta,critica'],
            'assigned_to' => ['nullable', 'exists:users,id'], // Permitir asignación (solo admin)
            'attachments' => ['nullable', 'array', 'max:3'],
            'attachments.*' => [
                'file',
                'max:5120', // 5MB
                'mimes:jpg,jpeg,png,pdf,doc,docx'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio',
            'title.min' => 'El título debe tener al menos :min caracteres',
            'description.required' => 'La descripción es obligatoria',
            'description.min' => 'La descripción debe tener al menos :min caracteres',
            'category.required' => 'La categoría es obligatoria',
            'category.in' => 'La categoría seleccionada no es válida',
            'subcategory.required' => 'La subcategoría es obligatoria',
            'subcategory.in' => 'La subcategoría seleccionada no es válida',
            'priority.required' => 'La prioridad es obligatoria',
            'priority.in' => 'La prioridad seleccionada no es válida',
            'attachments.max' => 'No puede adjuntar más de :max archivos',
            'attachments.*.file' => 'El archivo adjunto no es válido',
            'attachments.*.max' => 'El archivo no debe pesar más de :max kilobytes',
            'attachments.*.mimes' => 'El archivo debe ser de tipo: :values',
        ];
    }
}