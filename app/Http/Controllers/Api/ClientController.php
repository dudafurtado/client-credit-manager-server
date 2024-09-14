<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckClientOwnership;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\User;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(CheckClientOwnership::class)->only(['show', 'update', 'destroy']);
    }
    
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $clients = collect(); 

        if ($user instanceof User) {
            $clients = $user->clients()->paginate(10);
        }

        return response()->json($clients, 200);
    }

    public function show(Client $client): JsonResponse
    {
        $clientWithRelations = Client::with(['address', 'cards'])->find($client->id);
        return response()->json($clientWithRelations);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $user = Auth::user(); 
            $validated = $request->validated();
            $client = Client::create($validated);

            if ($user instanceof User) {
                $user->clients()->attach($client->id, [
                    'created_at' => now(), 
                    'updated_at' => now() 
                ]);
            }

            DB::commit();
    
            return response()->json($client, 201);
        } catch (Exception $error) {
            dd($error);
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function update(UpdateClientRequest $request, Client $client): JsonResponse
    {
        DB::beginTransaction();

        try {
            $client->name = $request->filled('name') ? $request->name : $client->name;
            $client->surname = $request->filled('surname') ? $request->surname : $client->surname;
            $client->email = $request->filled('email') ? $request->email : $client->email;
            $client->birth_date = $request->filled('birth_date') ? $request->birth_date : $client->birth_date;
            $client->phone = $request->filled('phone') ? $request->phone : $client->phone;

            $client->save();

            DB::commit();

            return response()->json($client);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function destroy(Client $client): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            if ($user instanceof User) {
                $user->clients()->updateExistingPivot($client->id, [
                    'deleted_at' => now()
                ]);
            }

            $client->cards()->delete();
            $client->address()->delete();
            $client->delete();
            
            DB::commit();

            return response()->json(null, 204);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }
}
