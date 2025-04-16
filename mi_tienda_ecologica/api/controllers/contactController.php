<?php
require_once __DIR__ . '/../../includes/db_connect.php';

function submitMessage($nombre, $email, $mensaje)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)");
    return $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':mensaje' => $mensaje
    ]);
}

function getMessages()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY fecha DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteMessage($id)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM mensajes_contacto WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
