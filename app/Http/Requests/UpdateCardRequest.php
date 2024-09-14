<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Card;
use App\Models\User;

class UpdateCardRequest extends FormRequest
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
            'number' => ['nullable', 'string', 'regex:/^\d{4} \d{4} \d{4} \d{4}$/', function ($attribute, $value, $fail) {
                $this->validateCardNumber($value, $fail);
            }],
            'expire_date' => ['nullable', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/', function ($attribute, $value, $fail) {
                $this->validateFutureDate($value, $fail);
            }],
            'CVV' => ['nullable', 'string', 'regex:/^\d{3}$/'],
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
     * Verification about unique card number from clients list of user.
     *
     * @param string $value
     * @param \Closure $fail
     */
    private function validateUniqueCardNumber($value, $fail)
    {
        $user = Auth::user();

        if ($user instanceof User) {
            $clientIds = $user->clients()->pluck('clients.id');

            $cardExists = Card::whereIn('client_id', $clientIds)
                ->where('number', $value)
                ->exists();

            if ($cardExists) {
                return $fail('Este número de cartão já está registrado para um dos seus clientes.');
            }
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
            'number.string' => 'O número do cartão deve ser uma sequência de caracteres.',
            'number.regex' => 'O número do cartão deve estar no formato 1234 5678 9012 3456.',

            'expire_date.string' => 'A data de expiração deve ser uma sequência de caracteres.',
            'expire_date.regex' => 'A data de expiração deve estar no formato MM/YY.',

            'CVV.string' => 'O CVV deve ser uma sequência de caracteres.',
            'CVV.size' => 'O CVV deve ter exatamente 3 dígitos.',

            'client_id.exists' => 'O client selecionado é inválido ou não existe.',
        ];
    }
}
