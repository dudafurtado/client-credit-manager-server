<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store (Request $request): JsonResponse
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json('Login incorreto', 419);
        } 

        $user = Auth::user();

        $token = $request->user()->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function destroy (User $user): JsonResponse 
    {
        try {
            $user->tokens()->delete();

            return response()->json('Logged out', 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e
            ],400);
        }
    }
}
