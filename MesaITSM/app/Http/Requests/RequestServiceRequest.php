<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestServiceRequest extends FormRequest
{
    protected ?Service $service = null;

    public function authorize(): bool
    {
        $this->service = Service::findOrFail($this->route('service'));
        return auth()->user()->role === 'usuario' && $this->service->is_active;
    }

    public function rules(): array
    {
        if (!$this->service) {
            return [];
        }

        $rules = [
            'service_id' => ['required', 'exists:services,id'],
        ];

        // Generar reglas dinámicas basadas en form_fields del servicio
        if (isset($this->service->form_fields['campos']) && is_array($this->service->form_fields['campos'])) {
            foreach ($this->service->form_fields['campos'] as $field) {
                $fieldRules = ['nullable'];
                
                if (isset($field['required']) && $field['required']) {
                    $fieldRules = ['required'];
                }

                switch ($field['type']) {
                    case 'text':
                        $fieldRules[] = 'string';
                        $fieldRules[] = 'max:255';
                        break;

                    case 'textarea':
                        $fieldRules[] = 'string';
                        break;

                    case 'select':
                    case 'radio':
                        if (isset($field['options']) && is_array($field['options'])) {
                            $fieldRules[] = Rule::in(array_keys($field['options']));
                        }
                        break;

                    case 'checkbox':
                        $fieldRules[] = 'boolean';
                        break;
                }

                $rules[$field['name']] = $fieldRules;
            }
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attributes = [
            'service_id' => 'servicio'
        ];

        if ($this->service && isset($this->service->form_fields['campos'])) {
            foreach ($this->service->form_fields['campos'] as $field) {
                $attributes[$field['name']] = $field['label'];
            }
        }

        return $attributes;
    }

    public function messages(): array
    {
        return [
            '*.required' => 'El campo :attribute es obligatorio.',
            '*.string' => 'El campo :attribute debe ser texto.',
            '*.max' => 'El campo :attribute no debe exceder :max caracteres.',
            '*.in' => 'El valor seleccionado para :attribute no es válido.',
            '*.boolean' => 'El campo :attribute debe ser verdadero o falso.',
        ];
    }
}