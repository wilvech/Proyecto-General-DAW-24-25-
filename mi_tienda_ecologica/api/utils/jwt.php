<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Composer para firebase/php-jwt

define('JWT_SECRET', 'tu_clave_secreta_segura'); // Reemplázala por una segura en .env/config

function createJWT($payload)
{
    $issuedAt = time();
    $expire = $issuedAt + (60 * 60 * 24); // 24 horas
    $token = [
        'iat' => $issuedAt,
        'exp' => $expire,
        'data' => $payload
    ];
    return JWT::encode($token, JWT_SECRET, 'HS256');
}

function decodeJWT($token)
{
    return JWT::decode($token, new Key(JWT_SECRET, 'HS256'))->data;
}
