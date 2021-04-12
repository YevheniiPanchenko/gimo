<?php

namespace Src\System;

class JWT
{
    public static function encode($data): string
    {
        $key = getenv('JWT_SECRET');
        $headers = [
            'alg' => 'sha256',
            'typ' => 'JWT'
        ];
        $headers_encoded = base64_encode(json_encode($headers));
        $payload = ['pass'=> $data['password'],'email'=> $data['email']];
        $payload_encoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256',"$headers_encoded.$payload_encoded", $key);
        return "$headers_encoded.$payload_encoded.$signature";
    }

    public static function decode($jwt_token): string
    {
        $key = getenv('JWT_SECRET');
        $jwt_arr = array_combine(['header', 'payload', 'signature'], explode('.', $jwt_token));
        return hash_hmac(
            'sha256',
            $jwt_arr['header'] . '.' . $jwt_arr['payload'],
            $key);
    }

    public static function verify($jwt_token): bool
    {
        $jwt_arr = array_combine(['header', 'payload', 'signature'], explode('.', $jwt_token));
        $signature = static::decode($jwt_token);
        if (hash_equals($jwt_arr['signature'], $signature)) {
            return true;
        }
        return false;
    }
}