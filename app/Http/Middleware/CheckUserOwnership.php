<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authenticatedUser = Auth::user();
        $userId = $request->route('user')->id;

        if ($authenticatedUser->id !== (int)$userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
