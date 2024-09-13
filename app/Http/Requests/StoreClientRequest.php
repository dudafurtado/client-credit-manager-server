<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Client;

class StoreClientRequest extends FormRequest
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
            'name.string' => 'O nome deve ser uma sequência de caracteres.',
            'name.max' => 'O nome não pode ter mais de :max caracteres.',

            'surname.required' => 'Campo sobrenome é obrigatório!',
            'surname.string' => 'O sobrenome deve ser uma sequência de caracteres.',
            'surname.max' => 'O sobrenome não pode ter mais de :max caracteres.',

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
