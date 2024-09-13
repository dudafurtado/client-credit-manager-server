<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;

class AddressController extends Controller
{
    public function index(): JsonResponse
    {
        $address = Address::paginate(10);
        return response()->json($address, 200);
    }

    public function show(Address $address): JsonResponse
    {
        return response()->json($address);
    }

    public function store(StoreAddressRequest $request): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $validated = $request->validated();
            $address = Address::create($validated);

            DB::commit();
    
            return response()->json($address, 201);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $address->update([
                'zip_code' => $request->filled('zip_code') ? $request->zip_code : $address->zip_code,
                'street' => $request->filled('street') ? $request->street : $address->street,
                'additional_information' => $request->filled('additional_information') ? $request->additional_information : $address->additional_information,
                'neighborhood' => $request->filled('neighborhood') ? $request->neighborhood : $address->neighborhood,
                'city' => $request->filled('city') ? $request->city : $address->city,
                'state' => $request->filled('state') ? $request->state : $address->state,
            ]);
            $address->save();         

            DB::commit();
    
            return response()->json($address, 200);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function destroy(Address $address): JsonResponse
    {
        try {
            $address->delete();

            return response()->json(null, 204);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
