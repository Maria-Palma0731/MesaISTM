<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EscalateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $ticket = $this->route('ticket');
        
        return $this->user()->role === 'tecnico' && 
               $ticket->assigned_to === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assigned_to' => ['required', 'exists:users,id', function ($attribute, $value, $fail) {
                $user = \App\Models\User::find($value);
                if ($user->role !== 'tecnico') {
                    $fail('El usuario seleccionado debe ser un técnico.');
                }
            }],
            'comment' => ['required', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'assigned_to.required' => 'Debes seleccionar un técnico.',
            'assigned_to.exists' => 'El técnico seleccionado no existe.',
            'comment.required' => 'El comentario es obligatorio.',
            'comment.max' => 'El comentario no puede exceder los 1000 caracteres.',
        ];
    }
}