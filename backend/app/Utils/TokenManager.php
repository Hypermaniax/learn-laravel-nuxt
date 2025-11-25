<?php

namespace App\Utils;

use Tymon\JWTAuth\Facades\JWTAuth;

class TokenManager
{
    private function resetTTL()
    {
        return JWTAuth::factory()->setTTL(config('jwt.ttl'));
    }

    public function createAccesToken($data)
    {
        JWTAuth::factory()->setTTL(15);
        $token = JWTAuth::fromUser($data);
        $this->resetTTL();
        return $token;
    }

    public function parseToken($refreshToken)
    {
        $payload = JWTAuth::setToken($refreshToken)->authenticate();
        
        return $payload;
    }

    public function createRefreshToken($data)
    {
        JWTAuth::factory()->setTTL(60 * 24 * 7);
        $token = JWTAuth::fromUser($data);
        $this->resetTTL();
        return $token;
    }
}
