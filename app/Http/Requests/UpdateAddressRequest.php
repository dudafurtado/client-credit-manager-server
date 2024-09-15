<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAddressRequest extends FormRequest
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
                'error' => $validator->errors()
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
            'zip_code' => 'nullable|string|max:10',
            'street' => 'nullable|string|max:255',
            'additional_information' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
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
            'zip_code.string' => 'O código postal (CEP) deve ser uma sequência de caracteres.',
            'zip_code.max' => 'O código postal (CEP) não pode ter mais de 10 caracteres.',

            'street.string' => 'O nome da rua deve ser uma sequência de caracteres.',
            'street.max' => 'O nome da rua não pode ter mais de 255 caracteres.',

            'additional_information.string' => 'As informações adicionais devem ser uma sequência de caracteres.',
            'additional_information.max' => 'As informações adicionais não podem ter mais de 255 caracteres.',

            'neighborhood.string' => 'O bairro deve ser uma sequência de caracteres.',
            'neighborhood.max' => 'O bairro não pode ter mais de 255 caracteres.',

            'city.string' => 'A cidade deve ser uma sequência de caracteres.',
            'city.max' => 'A cidade não pode ter mais de 255 caracteres.',

            'state.string' => 'O estado deve ser uma sequência de caracteres.',
            'state.max' => 'O estado não pode ter mais de 2 caracteres.',

            'client_id.exists' => 'O identificador do cliente é inválido ou não existe.',
        ];
    }
}
