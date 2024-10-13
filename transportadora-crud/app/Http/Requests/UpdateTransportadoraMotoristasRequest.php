<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportadoraMotoristasRequest extends FormRequest
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
            'motoristas' => 'required|array', 
            'motoristas.*' => 'uuid|exists:motoristas,id',
        ];
    }

    public function messages(): array
    {
        return [
            'motoristas.required' => 'O array de motoristas é obrigatório.',
            'motoristas.array' => 'Os motoristas devem ser enviados como um array.',
            'motoristas.*.uuid' => 'Cada motorista deve ter um ID válido.',
            'motoristas.*.exists' => 'Algum dos IDs fornecidos não corresponde a um motorista válido.',
        ];
    }
}
