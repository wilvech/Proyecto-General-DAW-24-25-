<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/config.php';
require_once '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Debes iniciar sesión.</p>";
    require_once '../includes/footer.php';
    exit;
}

if (empty($_SESSION['cart'])) {
    echo "<p>Carrito vacío. Nada que registrar.</p>";
    require_once '../includes/footer.php';
    exit;
}

// Calcular total
$total = 0;
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->execute([$product_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($producto) {
        $total += $producto['precio'] * $qty;
    }
}

// Insertar en tabla pedidos
$stmtPedido = $pdo->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)");
$stmtPedido->execute([$_SESSION['usuario_id'], $total]);
$pedido_id = $pdo->lastInsertId();

// Insertar detalles del pedido
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->execute([$product_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($producto) {
        $precio_unitario = $producto['precio'];
        $stmtDetalle = $pdo->prepare("INSERT INTO pedido_detalles (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
        $stmtDetalle->execute([$pedido_id, $product_id, $qty, $precio_unitario]);
    }
}

// Vaciar carrito
$_SESSION['cart'] = [];

echo "<h1>¡Pago exitoso!</h1>";
echo "<p>Gracias por tu compra. Tu número de pedido es <strong>#{$pedido_id}</strong></p>";

require_once '../includes/footer.php';
?>
