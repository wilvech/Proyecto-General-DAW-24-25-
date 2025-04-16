<?php
require_once __DIR__ . '/../utils/jwt.php';

function verifyJWT($request, $handler)
{
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(['message' => 'Token no proporcionado']);
        exit;
    }

    $token = $matches[1];

    try {
        $decoded = decodeJWT($token);
        $_SESSION['user'] = $decoded;
        return $handler->handle($request);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['message' => 'Token inválido: ' . $e->getMessage()]);
        exit;
    }
}
