<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaminhaoRequest extends FormRequest
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
            'motorista_id' => 'required|exists:motoristas,motorista_id',
            'modelo_id' => 'required|exists:modelos,modelo_id',
            'placa' => 'required|string|size:8|unique:caminhoes,placa_caminhao',
        ];
    }

    public function messages()
    {
        return [
            'motorista_id.required' => 'O motorista é obrigatório.',
            'motorista_id.exists' => 'O motorista selecionado não existe.',
            'modelo_id.required' => 'O modelo do caminhão é obrigatório.',
            'modelo_id.exists' => 'O modelo selecionado não existe.',
            'placa.required' => 'A placa do caminhão é obrigatória.',
            'placa.size' => 'A placa deve ter exatamente 8 caracteres.',
            'placa.unique' => 'Esta placa já está cadastrada.',
        ];
    }
}
