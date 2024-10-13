<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportadoraRequest extends FormRequest
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
            'nome' => 'required|string|max:100',
            'cnpj' => 'required|numeric|digits:14|unique:transportadoras,cnpj_transportadora'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome da transportadora é obrigatório.',
            'cnpj.required' => 'O CNPJ da transportadora é obrigatório.',
            'cnpj.numeric' => 'O CNPJ deve ser numérico.',
            'cnpj.digits' => 'O CNPJ deve ter exatamente 14 dígitos.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
        ];
    }
}
