<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'tecnico' &&
               $this->route('ticket')->assigned_to === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ticket = $this->route('ticket');

        return [
            'status' => ['required', 'string', function ($attribute, $value, $fail) use ($ticket) {
                if (!$ticket->canTransitionTo($value)) {
                    $fail("No se puede cambiar el estado de '{$ticket->status}' a '{$value}'.");
                }
            }],
            'priority' => ['sometimes', 'required', 'string', 'in:baja,media,alta,critica'],
            'time_minutes' => ['required', 'integer', 'min:1', 'max:480'],
            'time_description' => ['required', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:1000'],
            'is_internal' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'El estado es obligatorio.',
            'time_minutes.required' => 'Debes registrar el tiempo invertido.',
            'time_minutes.integer' => 'El tiempo debe ser un número entero.',
            'time_minutes.min' => 'El tiempo mínimo es 1 minuto.',
            'time_minutes.max' => 'El tiempo máximo es 8 horas (480 minutos).',
            'time_description.required' => 'La descripción del tiempo es obligatoria.',
            'comment.required' => 'El comentario es obligatorio.',
        ];
    }
}