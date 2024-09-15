<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function store (LoginRequest $request): JsonResponse
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Login incorreto'], 419);
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

            return response()->json(['message' => 'Logged out'], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e
            ],400);
        }
    }
}
