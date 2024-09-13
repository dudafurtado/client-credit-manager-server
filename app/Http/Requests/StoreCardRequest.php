<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;

class StoreCardRequest extends FormRequest
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
            'number' => ['required', 'string', 'regex:/^\d{4} \d{4} \d{4} \d{4}$/', function ($attribute, $value, $fail) {
                $this->validateCardNumber($value, $fail);
            }],
            'expire_date' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/', function ($attribute, $value, $fail) {
                $this->validateFutureDate($value, $fail);
            }],
            'CVV' => ['required', 'string', 'regex:/^\d{3}$/'],
            'client_id' => ['nullable', 'exists:clients,id'],
        ];
    }

    /**
     * Custom validation for card number with Algoritmo of Luhn.
     *
     * @param string $value
     * @param \Closure $fail
     */
    private function validateCardNumber($value, $fail)
    {
        $cardNumber = preg_replace('/\D/', '', $value);
        $sum = 0;
        $shouldDouble = false;

        for ($i = strlen($cardNumber) - 1; $i >= 0; $i--) {
            $digit = $cardNumber[$i];

            if ($shouldDouble) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
            $shouldDouble = !$shouldDouble;
        }

        if(($sum % 10) !== 0) {
            return $fail('O número do cartão é inválido');
        }
    }

    /**
     * Custom validation for expire_date.
     *
     * @param string $value
     * @param \Closure $fail
     */
    private function validateFutureDate($value, $fail)
    {
        [$month, $year] = explode('/', $value);

        $month = (int) $month;
        $year = (int) ('20' . $year);
        $expirationDate = Carbon::create($year, $month, 1);
        $nextMonth = Carbon::now()->addMonth()->startOfMonth();

        if ($expirationDate->lessThan($nextMonth)) {
            return $fail('Não é possível adicionar um cartão que está perto de vencer ou já venceu. Por favor, tente outro.');
        }
    }

    public function messages(): array
    {
        return [
            'number.required' => 'O número do cartão é obrigatório.',
            'number.string' => 'O número do cartão deve ser uma sequência de caracteres.',
            'number.regex' => 'O número do cartão deve estar no formato 1234 5678 9012 3456. Ou seja, deve conter apenas dígitos e ter exatamente 16 dígitos.',

            'expire_date.required' => 'A data de expiração é obrigatória.',
            'expire_date.string' => 'A data de expiração deve ser uma sequência de caracteres.',
            'expire_date.regex' => 'A data de expiração deve estar no formato MM/YY.',

            'CVV.required' => 'O CVV é obrigatório.',
            'CVV.string' => 'O CVV deve ser uma sequência de caracteres.',
            'CVV.regex' => 'O CVV deve ter exatamente 3 dígitos no formato 137.',

            'client_id.exists' => 'O identificador do cliente é inválido ou não existe.',
        ];
    }
}
