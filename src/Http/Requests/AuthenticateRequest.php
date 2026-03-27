<?php

namespace LechugaNegra\PrivKeyManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitir que cualquier usuario intente iniciar sesión
    }

    public function rules(): array
    {
        $rules = [
            'api_key' => 'required|string|min:64|max:64',
        ];
    
        return $rules;
    }

    public function messages()
    {
        return [
            'api_key.required' => 'The API Key is required.',
            'api_key.string' => 'The API Key must be a string.',
            'api_key.min' => 'The API Key must be at least 64 characters long.',
            'api_key.max' => 'The API Key must not exceed 64 characters.',
        ];
    }
}
