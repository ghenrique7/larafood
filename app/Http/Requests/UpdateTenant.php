<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTenant extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'min:3', 'max:255', Rule::unique('tenants')->ignore($this->tenant)],
            'cnpj' => ['required', 'digits:14', Rule::unique('tenants')->ignore($this->tenant)],
            'email' => ['required', 'email', Rule::unique('tenants')->ignore($this->tenant)],
            'logo' => ['nullable', 'image']
        ];

        return $rules;
    }
}
