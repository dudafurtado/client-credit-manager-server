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
                'zip_code' => $request->zip_code,
                'street' => $request->street,
                'additional_information' => $request->additional_information,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'state' => $request->state,
            ]);            

            DB::commit();
    
            return response()->json($address, 201);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }
}
