<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
    * 
    * @param  \Illuminate\Contracts\Validation\Validator 
    * @throws \Illuminate\Http\Exceptions\HttpResponseException
    *
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
            'zip_code' => 'required|string|max:10',
            'street' => 'required|string|max:255',
            'additional_information' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'client_id' => ['nullable', 'exists:clients,id'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'zip_code.required' => 'O código postal (CEP) é obrigatório.',
            'zip_code.string' => 'O código postal (CEP) deve ser uma sequência de caracteres.',
            'zip_code.max' => 'O código postal (CEP) não pode ter mais de :max caracteres.',

            'street.required' => 'O nome da rua é obrigatório.',
            'street.string' => 'O nome da rua deve ser uma sequência de caracteres.',
            'street.max' => 'O nome da rua não pode ter mais de :max caracteres.',

            'additional_information.string' => 'As informações adicionais devem ser uma sequência de caracteres.',
            'additional_information.max' => 'As informações adicionais não podem ter mais de :max caracteres.',

            'neighborhood.required' => 'O bairro é obrigatório.',
            'neighborhood.string' => 'O bairro deve ser uma sequência de caracteres.',
            'neighborhood.max' => 'O bairro não pode ter mais de :max caracteres.',

            'city.required' => 'A cidade é obrigatória.',
            'city.string' => 'A cidade deve ser uma sequência de caracteres.',
            'city.max' => 'A cidade não pode ter mais de :max caracteres.',

            'state.required' => 'O estado é obrigatório.',
            'state.string' => 'O estado deve ser uma sequência de caracteres.',
            'state.max' => 'O estado não pode ter mais de :max caracteres.',

            'client_id.exists' => 'O identificador do cliente é inválido ou não existe.',
        ];
    }
}
