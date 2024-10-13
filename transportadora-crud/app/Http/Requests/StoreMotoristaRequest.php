<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreMotoristaRequest extends FormRequest
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
    public function rules()
    {
        return [
            'nome' => 'required|string|max:100',
            'cpf' => 'required|numeric|digits:11|unique:motoristas,cpf_motorista',
            'data_nascimento' => 'required|date|before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            'email' => 'nullable|email|max:100',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome do motorista é obrigatório.',
            'cpf.required' => 'O CPF do motorista é obrigatório.',
            'cpf.numeric' => 'O CPF deve ser numérico.',
            'cpf.digits' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'data_nascimento.before_or_equal' => 'O motorista deve ser maior de idade (18 anos ou mais).',
            'email.email' => 'O campo email deve ser um email válido.',
        ];
    }
}
