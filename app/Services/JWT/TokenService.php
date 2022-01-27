<?php

namespace App\Services\JWT;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService implements TokenServiceInterface
{
    static public function generateToken($data, $addTime = 86400) { // время жизни по умолчанию 1 день
        $iat = time(); // время в формате Unix Time, определяющее момент, когда токен был создан
        $nbf = $iat + 10; // время в формате Unix Time, определяющее момент, когда токен станет валидным
        $exp = $iat + $addTime; // время в формате Unix Time, определяющее момент, когда токен станет невалидным

        $payload = [
            "iss" => env('APP_URL', 'http://localhost'), // строка, содержащая имя или идентификатор приложения
            "aud" => env('APP_URL', 'http://localhost'),
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $exp,
            "data" => $data
        ];

        return [
            'token' => JWT::encode($payload, env('JWT_SECRET', 'secret_key'), env('JWT_ALGORITHM', 'HS256')),
            'exp' => $exp
        ];
    }

    static public function isValid($token) {
        try {
            return JWT::decode($token, new Key($key, env('JWT_ALGORITHM', 'HS256')));
        } catch (Exception $e) {
            return false;
        }
    }
}
