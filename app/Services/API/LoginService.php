<?php

namespace App\Services\API;

use Illuminate\Support\Facades\Redis;
use App\Services\JWT\TokenService;

class LoginService
{
    static public function generateAccessAndRefreshTokens($user) {
        $data = ['id' => $user->id, 'role' => $user->role];

        $result = TokenService::generateToken($data); 

        $refreshToken = TokenService::generateToken($data, 60 * 24 * 60 * 60)['token']; // 60 дней

        Redis::command('SADD', [(string)$user->id, $refreshToken]); // сохроняем refreshToken пользователя

        return [
            'accessToken' => $result['token'],
            'refreshToken' => $refreshToken,
            'tokenType' => 'bearer',
            'expirationTime' => $result['exp']
        ];
    }
}