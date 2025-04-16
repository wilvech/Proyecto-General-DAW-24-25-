<?php
require_once __DIR__ . '/../../includes/db_connect.php';
require_once __DIR__ . '/../utils/jwt.php';
require_once __DIR__ . '/../utils/sendEmail.php';

function register($nombre, $email, $password, $direccion = '', $telefono = '')
{
    global $pdo;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol)
            VALUES (:nombre, :email, :password, :direccion, :telefono, 'cliente')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':direccion' => $direccion,
        ':telefono' => $telefono
    ]);
    return ['message' => 'Usuario registrado con éxito'];
}

function login($email, $password)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $token = generateJWT($user['id'], $user['email']);
        return [
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'email' => $user['email'],
                'rol' => $user['rol']
            ]
        ];
    } else {
        throw new Exception("Credenciales incorrectas");
    }
}

function getUser($userId)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT id, nombre, email, direccion, telefono, rol FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUser($userId, $data)
{
    global $pdo;

    $sql = "UPDATE usuarios SET nombre=:nombre, direccion=:direccion, telefono=:telefono WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $data['nombre'],
        ':direccion' => $data['direccion'],
        ':telefono' => $data['telefono'],
        ':id' => $userId
    ]);

    return ['message' => 'Perfil actualizado con éxito'];
}

function changePassword($userId, $oldPassword, $newPassword)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($oldPassword, $user['password'])) {
        throw new Exception("La contraseña actual es incorrecta");
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
    $stmt->execute([
        ':password' => $hashedPassword,
        ':id' => $userId
    ]);

    return ['message' => 'Contraseña actualizada con éxito'];
}

function forgotPassword($email)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("No se encontró un usuario con ese correo");
    }

    $token = bin2hex(random_bytes(32));
    $resetUrl = BASE_URL . "/auth/reset_password.php?token=$token";

    $_SESSION['reset_tokens'][$token] = [
        'user_id' => $user['id'],
        'expires' => time() + 3600
    ];

    sendEmail($email, "Recuperación de contraseña", "Haz clic en este enlace para restablecer tu contraseña: $resetUrl");

    return ['message' => 'Correo enviado con instrucciones'];
}

function resetPassword($token, $newPassword)
{
    if (!isset($_SESSION['reset_tokens'][$token])) {
        throw new Exception("Token inválido o expirado");
    }

    $resetInfo = $_SESSION['reset_tokens'][$token];
    if (time() > $resetInfo['expires']) {
        unset($_SESSION['reset_tokens'][$token]);
        throw new Exception("El token ha expirado");
    }

    global $pdo;
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
    $stmt->execute([
        ':password' => $hashedPassword,
        ':id' => $resetInfo['user_id']
    ]);

    unset($_SESSION['reset_tokens'][$token]);
    return ['message' => 'Contraseña restablecida con éxito'];
}
