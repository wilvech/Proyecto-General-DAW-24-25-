<?php
require_once __DIR__ . '/../../includes/db_connect.php';
require_once __DIR__ . '/../utils/jwt.php';

function login($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $token = generateJWT($user['id'], $user['email'], $user['rol']);
        return ['success' => true, 'token' => $token, 'user' => $user];
    }

    return ['success' => false, 'message' => 'Credenciales inválidas'];
}

function register($data) {
    global $pdo;

    $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) VALUES (:nombre, :email, :password, :direccion, :telefono, 'cliente')");

    $success = $stmt->execute([
        ':nombre' => $data['nombre'],
        ':email' => $data['email'],
        ':password' => $passwordHash,
        ':direccion' => $data['direccion'],
        ':telefono' => $data['telefono']
    ]);

    return ['success' => $success];
}
