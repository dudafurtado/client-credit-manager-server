<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Card;
use App\Models\Address;

class CheckClientOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $clientId = $request->route('client')->id;

        if ($user instanceof User) {
            $clientExists = $user->clients()
                ->wherePivot('deleted_at', null)
                ->where('client_id', $clientId)
                ->exists();

            if (!$clientExists) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $card = $request->route('card');
            if ($card instanceof Card) {
                $cardClient = $card->client;
                if ($cardClient->id !== $clientId) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
            }

            $address = $request->route('address');
            if ($address instanceof Address) {
                $addressClient = $address->client;
                if ($addressClient->id !== $clientId) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
            }
        }

        return $next($request);
    }
}
