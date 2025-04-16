<?php
require_once __DIR__ . '/../../includes/db_connect.php';

function getAllProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM productos");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createProduct($data, $imageName) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, categoria, stock, imagen) VALUES (:nombre, :descripcion, :precio, :categoria, :stock, :imagen)");
    return $stmt->execute([
        ':nombre' => $data['nombre'],
        ':descripcion' => $data['descripcion'],
        ':precio' => $data['precio'],
        ':categoria' => $data['categoria'],
        ':stock' => $data['stock'],
        ':imagen' => $imageName
    ]);
}

function updateProduct($id, $data, $imageName) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE productos SET nombre=:nombre, descripcion=:descripcion, precio=:precio, categoria=:categoria, stock=:stock, imagen=:imagen WHERE id=:id");
    return $stmt->execute([
        ':nombre' => $data['nombre'],
        ':descripcion' => $data['descripcion'],
        ':precio' => $data['precio'],
        ':categoria' => $data['categoria'],
        ':stock' => $data['stock'],
        ':imagen' => $imageName,
        ':id' => $id
    ]);
}

function deleteProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
