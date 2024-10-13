<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportadoraStatusRequest extends FormRequest
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
        return [
            'status' => 'required|integer|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'O status da transportadora é obrigatório.',
            'status.integer' => 'O status da transportadora deve ser um número inteiro.',
            'status.in' => 'O status da transportadora deve ser 0 (inativo) ou 1 (ativo).',
        ];
    }
}
