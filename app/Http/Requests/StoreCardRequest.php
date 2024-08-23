<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
    * Manipular falha de validação e retornar uma resposta JSON com os erros de validação.
    *
    * @param  \Illuminate\Contracts\Validation\Validator  $validator O objeto de validação que contém os erros de validação.
    * @throws \Illuminate\Http\Exceptions\HttpResponseException
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors()
            ])->setStatusCode(422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'string', 'regex:/^\d{4} \d{4} \d{4} \d{4}$/'],
            'expire_date' => 'required|string|regex:/^\d{2}\/\d{2}$/',
            'CVV' => 'required|string|size:3',
            'client_id' => ['nullable', 'exists:clients,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'number.required' => 'O número do cartão é obrigatório.',
            'number.string' => 'O número do cartão deve ser uma sequência de caracteres.',
            'number.regex' => 'O número do cartão deve estar no formato 1234 5678 9012 3456.',

            'expire_date.required' => 'A data de expiração é obrigatória.',
            'expire_date.string' => 'A data de expiração deve ser uma sequência de caracteres.',
            'expire_date.regex' => 'A data de expiração deve estar no formato MM/YY.',

            'CVV.required' => 'O CVV é obrigatório.',
            'CVV.string' => 'O CVV deve ser uma sequência de caracteres.',
            'CVV.size' => 'O CVV deve ter exatamente 3 dígitos.',

            'client_id.exists' => 'O client selecionado é inválido ou não existe.',
        ];
    }
}
