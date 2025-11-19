<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $ticket = $this->route('ticket');
        
        if ($this->user()->role === 'tecnico') {
            return $ticket->assigned_to === $this->user()->id;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => ['required', 'string', 'max:1000'],
            'is_internal' => ['sometimes', 'boolean'],
            'attachments.*' => ['sometimes', 'file', 'max:10240', 'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'comment.required' => 'El comentario es obligatorio.',
            'comment.max' => 'El comentario no puede exceder los 1000 caracteres.',
            'attachments.*.max' => 'El archivo no puede exceder los 10MB.',
            'attachments.*.mimes' => 'Formato de archivo no soportado.',
        ];
    }
}