<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Card;
use App\Models\Client;

class CardController extends Controller
{
    public function index(Client $client)
    {
        $cards = Card::where('client_id', $client->id)->paginate(10);

        return response()->json($cards, 200);
    }

    public function show(Client $client, Card $card)
    {
        return response()->json($card);
    }

    public function store(StoreCardRequest $request, Client $client)
    {
        DB::beginTransaction();
        
        try {
            $card = Card::create([
                'number' => $request->number,
                'expire_date' => $request->expire_date,
                'CVV' => $request->CVV,
                'client_id' => $client->id
            ]);

            DB::commit();
    
            return response()->json($card, 201);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function update(UpdateCardRequest $request, Client $client, Card $card)
    {
        DB::beginTransaction();
        
        try {
            $card->update([
                'number' => $request->filled('number') ? $request->number : $card->number,
                'expire_date' => $request->filled('expire_date') ? $request->expire_date : $card->expire_date,
                'CVV' => $request->filled('CVV') ? $request->CVV : $card->CVV,
            ]);
            $card->save();                 

            DB::commit();
    
            return response()->json($card, 200);
        } catch (Exception $error) {
            DB::rollback();
            return response()->json($error, 400);
        }
    }

    public function destroy(Client $client, Card $card): JsonResponse
    {
        try {
            $card->delete();

            return response()->json(null, 204);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
