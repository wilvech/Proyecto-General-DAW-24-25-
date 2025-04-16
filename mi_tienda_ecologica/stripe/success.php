<?php
session_start();
require_once '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>No estás autenticado.</p>";
    require_once '../includes/footer.php';
    exit;
}

require_once '../includes/db_connect.php';

$total = 0;
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->execute([$product_id]);
    $prod = $stmt->fetch();
    $total += $prod['precio'] * $qty;
}

$stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, fecha, total) VALUES (?, NOW(), ?)");
$stmt->execute([$_SESSION['usuario_id'], $total]);
$pedido_id = $pdo->lastInsertId();

foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->execute([$product_id]);
    $prod = $stmt->fetch();
    $pdo->prepare("INSERT INTO pedido_detalles (pedido_id, producto_id, cantidad, precio_unitario)
                   VALUES (?, ?, ?, ?)")->execute([$pedido_id, $product_id, $qty, $prod['precio']]);
}

$_SESSION['cart'] = [];
?>

<h1>¡Pago exitoso!</h1>
<p>Gracias por tu compra. Tu número de pedido es <strong>#<?= $pedido_id ?></strong>.</p>

<?php require_once '../includes/footer.php'; ?>
