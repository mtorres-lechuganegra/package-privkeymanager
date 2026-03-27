<?php

namespace LechugaNegra\PrivKeyManager\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use LechugaNegra\PrivKeyManager\Models\PrivKey;

class PrivKeyMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload();

            $privKey = PrivKey::where('id', $payload->get('sub'))
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })
                ->first();

            if (!$privKey instanceof PrivKey) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
