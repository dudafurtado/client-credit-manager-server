<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Client;

class StoreClientRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Client::class],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'regex:/^\(\d{2}\) \d{5}-\d{4}$/'],
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
            'name.required' => 'Campo nome é obrigatório!',

            'surname.required' => 'Campo sobrenome é obrigatório!',

            'email.required' => 'Campo email é obrigatório!',
            'email.email' => 'Necessário enviar um email válido!',
            'email.unique' => 'Esse email já existe. Tente outro!',

            'birth_date.required' => 'Campo data de nascimento é obrigatório!',
            'birth_date.date' => 'Data de nascimento deve ser uma data válida!',
            'birth_date.before' => 'Data de nascimento deve ser anterior a hoje!',

            'phone.required' => 'Campo telefone é obrigatório!',
            'phone.regex' => 'O telefone deve estar no formato (71) 99999-4774!',
        ];
    }
}
