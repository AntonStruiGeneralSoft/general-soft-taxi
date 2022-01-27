<?php

namespace App\Services\JWT;

interface TokenServiceInterface
{
    static public function generateToken($data, $addTime);

    static public function isValid($token);
}