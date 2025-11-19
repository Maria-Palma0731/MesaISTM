<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'icon',
        'estimated_time',
        'form_fields',
        'department',
        'priority_default',
        'is_active',
        'order'
    ];

    protected $casts = [
        'form_fields' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Helper para validar la estructura del JSON de form_fields
    public function validateFormFields(): bool
    {
        if (!is_array($this->form_fields) || !isset($this->form_fields['campos']) || !is_array($this->form_fields['campos'])) {
            return false;
        }

        foreach ($this->form_fields['campos'] as $field) {
            if (!isset($field['name'], $field['type'], $field['label'])) {
                return false;
            }

            if (!in_array($field['type'], ['text', 'textarea', 'select', 'radio', 'checkbox'])) {
                return false;
            }
        }

        return true;
    }

    // Helper para generar HTML del formulario dinámico
    public function generateFormHtml(): string
    {
        if (!$this->validateFormFields()) {
            return '';
        }

        $html = '';
        foreach ($this->form_fields['campos'] as $field) {
            $html .= match($field['type']) {
                'text' => $this->generateTextField($field),
                'textarea' => $this->generateTextareaField($field),
                'select' => $this->generateSelectField($field),
                'radio' => $this->generateRadioField($field),
                'checkbox' => $this->generateCheckboxField($field),
                default => ''
            };
        }

        return $html;
    }

    private function generateTextField(array $field): string
    {
        $required = isset($field['required']) && $field['required'] ? 'required' : '';
        return sprintf(
            '<div class="mb-4">
                <label for="%s" class="block text-sm font-medium text-gray-700">%s</label>
                <input type="text" name="%s" id="%s" %s class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>',
            $field['name'],
            $field['label'],
            $field['name'],
            $field['name'],
            $required
        );
    }

    private function generateTextareaField(array $field): string
    {
        $required = isset($field['required']) && $field['required'] ? 'required' : '';
        return sprintf(
            '<div class="mb-4">
                <label for="%s" class="block text-sm font-medium text-gray-700">%s</label>
                <textarea name="%s" id="%s" %s rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>',
            $field['name'],
            $field['label'],
            $field['name'],
            $field['name'],
            $required
        );
    }

    private function generateSelectField(array $field): string
    {
        if (!isset($field['options']) || !is_array($field['options'])) {
            return '';
        }

        $options = '';
        foreach ($field['options'] as $value => $label) {
            $options .= sprintf('<option value="%s">%s</option>', $value, $label);
        }

        $required = isset($field['required']) && $field['required'] ? 'required' : '';
        return sprintf(
            '<div class="mb-4">
                <label for="%s" class="block text-sm font-medium text-gray-700">%s</label>
                <select name="%s" id="%s" %s class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Selecciona una opción</option>
                    %s
                </select>
            </div>',
            $field['name'],
            $field['label'],
            $field['name'],
            $field['name'],
            $required,
            $options
        );
    }

    private function generateRadioField(array $field): string
    {
        if (!isset($field['options']) || !is_array($field['options'])) {
            return '';
        }

        $options = '';
        foreach ($field['options'] as $value => $label) {
            $options .= sprintf(
                '<div class="flex items-center">
                    <input type="radio" name="%s" value="%s" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="%s_%s" class="ml-3 block text-sm font-medium text-gray-700">%s</label>
                </div>',
                $field['name'],
                $value,
                $field['name'],
                $value,
                $label
            );
        }

        return sprintf(
            '<div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">%s</label>
                <div class="mt-2 space-y-2">%s</div>
            </div>',
            $field['label'],
            $options
        );
    }

    private function generateCheckboxField(array $field): string
    {
        return sprintf(
            '<div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="%s" id="%s" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="%s" class="ml-3 block text-sm font-medium text-gray-700">%s</label>
                </div>
            </div>',
            $field['name'],
            $field['name'],
            $field['name'],
            $field['label']
        );
    }
}