<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAddressRequest extends FormRequest
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
            'zip_code' => 'required|string|max:10',
            'street' => 'required|string|max:255',
            'additional_information' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
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
            'zip_code.max' => 'O código postal (CEP) não pode ter mais de 10 caracteres.',

            'street.required' => 'O nome da rua é obrigatório.',
            'street.string' => 'O nome da rua deve ser uma sequência de caracteres.',
            'street.max' => 'O nome da rua não pode ter mais de 255 caracteres.',

            'additional_information.string' => 'As informações adicionais devem ser uma sequência de caracteres.',
            'additional_information.max' => 'As informações adicionais não podem ter mais de 255 caracteres.',

            'neighborhood.required' => 'O bairro é obrigatório.',
            'neighborhood.string' => 'O bairro deve ser uma sequência de caracteres.',
            'neighborhood.max' => 'O bairro não pode ter mais de 255 caracteres.',

            'city.required' => 'A cidade é obrigatória.',
            'city.string' => 'A cidade deve ser uma sequência de caracteres.',
            'city.max' => 'A cidade não pode ter mais de 255 caracteres.',

            'state.required' => 'O estado é obrigatório.',
            'state.string' => 'O estado deve ser uma sequência de caracteres.',
            'state.max' => 'O estado não pode ter mais de 2 caracteres.',
        ];
    }
}
