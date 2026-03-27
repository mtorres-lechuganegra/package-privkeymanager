<?php

namespace LechugaNegra\PrivKeyManager\Http\Controllers;

use App\Http\Controllers\Controller;
use LechugaNegra\PrivKeyManager\Services\PrivKeyManagerService;
use LechugaNegra\PrivKeyManager\Http\Requests\AuthenticateRequest;
use LechugaNegra\PrivKeyManager\Models\PrivKey;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class PrivKeyController extends Controller
{
    protected $authService;

    public function __construct(PrivKeyManagerService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Inicia sesión y devuelve el token JWT.
     *
     * @param AuthenticateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(AuthenticateRequest $request)
    {
        try {
            $privKey = PrivKey::where('key', $request->api_key)
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })
                ->first();

            if (!$privKey) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            if ($privKey->referer_url) {
                $referer = $request->headers->get('Referer');

                if (!$referer || !str_starts_with($referer, $privKey->referer_url)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            }

            $token = JWTAuth::fromUser($privKey);
            return $this->authService->respondWithToken($token);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
