<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Models\Client;

class AddressController extends Controller
{
    public function index(Client $client): JsonResponse
    {
        $addresses = Address::where('client_id', $client->id)->paginate(10);
        
        return response()->json($addresses, 200);
    }

    public function show(Client $client, Address $address): JsonResponse
    {
        return response()->json($address);
    }

    public function store(StoreAddressRequest $request, Client $client): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $address = Address::create([
                'zip_code' => $request->zip_code,
                'street' => $request->street,
                'additional_information' => $request->additional_information,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'state' => $request->state,
                'client_id' => $client->id
            ]);

            DB::commit();
    
            return response()->json($address, 201);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function destroy(Client $client, Address $address): JsonResponse
    {
        try {
            $address->delete();

            return response()->json(null, 204);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
