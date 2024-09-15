<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ValidateCodeService 
{
  public function validateCode($email, $code): array
  {
    $passwordResetTokens = DB::table('password_reset_tokens')
      ->where('email', $email)
      ->whereNull('deleted_at')
      ->first();

    if(!$passwordResetTokens) {
      return [
        'status' => 'Error',
        'message' => 'Código não encontrado!'
      ];
    }

    if(!Hash::check($code, $passwordResetTokens->token)) {
      return [
        'status' => 'Error',
        'message' => 'Código inválido!'
      ];
    }

    $differenceInMinutes = Carbon::parse($passwordResetTokens->created_at)->diffInMinutes(Carbon::now());

    if ($differenceInMinutes > 15) {
      DB::table('password_reset_tokens')
        ->where('email', $email)
        ->update(['deleted_at' => Carbon::now()]);


      return [
        'status' => 'Error',
        'message' => 'O código expirou!'
      ];
    }

    return [
      'status' => 'Ok',
      'message' => 'Código validado!'
    ];
  }
}