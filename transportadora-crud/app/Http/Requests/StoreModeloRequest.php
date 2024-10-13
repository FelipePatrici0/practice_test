<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModeloRequest extends FormRequest
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
            'modelo' => 'required|string|max:50',
            'cor' => 'required|string|max:50',
        ];
    }

    public function messages()
    {
        return [
            'modelo.required' => 'O modelo do caminhão é obrigatório.',
            'cor.required' => 'A cor do caminhão é obrigatória.',
        ];
    }
}
