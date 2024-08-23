<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        $clients = Client::paginate(10);
        return response()->json($clients, 200);
    }

    public function show(string $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $client = Client::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
            ]);
            

            DB::commit();
    
            return response()->json($client, 201);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function update(UpdateClientRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $client = Client::findOrFail($id);

            $client->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
            ]);

            DB::commit();

            return response()->json($client);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();

            return response()->json(null, 204);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
