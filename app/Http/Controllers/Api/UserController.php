<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index (): JsonResponse 
    {
        $users = User::orderBy('id', 'DESC')->paginate(2);

        return response()->json($users, 200);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user, 200);
    }
    
    public function store(StoreUserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            DB::commit();

            return response()->json($user, 201);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            DB::commit();

            return response()->json($user, 201);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();

            return response()->json([
                'message' => 'User Deleted'
            ], 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
