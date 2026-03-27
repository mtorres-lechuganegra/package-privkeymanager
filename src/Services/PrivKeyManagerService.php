<?php

namespace LechugaNegra\PrivKeyManager\Services;

class PrivKeyManagerService
{
    /**
     * Formatea la respuesta con el token JWT.
     *
     * @param string $token Token JWT generado.
     * @return \Illuminate\Http\JsonResponse Respuesta con token, tipo y expiración.
     */
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }
}
