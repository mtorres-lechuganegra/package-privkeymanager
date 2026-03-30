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

            // Si es unrestricted, pasa sin validar grupos
            if ($privKey->isUnrestricted()) {
                return $next($request);
            }

            // Valida que la ruta actual esté en algún grupo asignado a la key
            $routeName = $request->route()->getName();

            if (!$routeName) {
                return response()->json(['error' => 'Forbidden — route has no name'], 403);
            }

            $hasAccess = $privKey->groups
                ->flatMap->routes
                ->pluck('route_name')
                ->contains($routeName);

            if (!$hasAccess) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
