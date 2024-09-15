<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ValidateCodeRequest;
use App\Mail\EmailForgotPasswordCode;
use App\Service\ValidateCodeService;
use App\Models\User;
use Carbon\Carbon;

class RecoverPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Não é possível recuperar a senha de um e-mail que não está cadastrado.'
                ], 400);
            }

            $code = mt_rand(100000, 999999);
            $token = Hash::make($code);

            $newPasswordResets = DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            if($newPasswordResets) {
                $currentDate = Carbon::now();
                $fifteenMinLater = $currentDate->addMinutes(15);
                $formattedTime = $fifteenMinLater->format('H:i');
                $formattedDate = $fifteenMinLater->format('d/m/y');

                Mail::to($user->email)->send(new EmailForgotPasswordCode($user, $code, $formattedDate, $formattedTime));
            }
    
            return response()->json([
                'status' => 'Ok',
                'message' => 'Código de recuperação da senha enviado para o email.'
            ], 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

    public function validateCode(ValidateCodeRequest $request, ValidateCodeService $validateCodeService): JsonResponse
    
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Usuário não encontrado!'
                ], 400);
            }

            $validationResult = $validateCodeService->validateCode($request->email, $request->code);

            if($validationResult['status'] === 'Error') {
                return response()->json([
                    'status' => $validationResult['status'],
                    'message' => $validationResult['message']
                ], 400);
            }
    
            return response()->json([
                'status' => 'Ok',
                'message' => 'Código para Recuperar a Senha Válido!'
            ], 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

    public function resetPassword(ResetPasswordRequest $request, ValidateCodeService $validateCodeService): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Usuário não encontrado!'
                ], 400);
            }

            $validationResult = $validateCodeService->validateCode($request->email, $request->code);

            if($validationResult['status'] === 'Error') {
                return response()->json([
                    'status' => $validationResult['status'],
                    'message' => $validationResult['message']
                ], 400);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->update(['deleted_at' => Carbon::now()]);

            DB::commit();
    
            return response()->json([
                'status' => 'Ok',
                'message' => 'Senha atualizada com sucesso!'
            ], 201);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }
}
