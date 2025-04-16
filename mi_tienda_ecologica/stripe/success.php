<?php
require_once '../includes/header.php';

if (isset($_SESSION['usuario_id']) && !empty($_SESSION['cart'])) {
    // Registrar el pedido en la base de datos
    $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, fecha, total, estado) VALUES (:usuario_id, NOW(), :total, 'pagado')");
    $total = 0;

    foreach ($_SESSION['cart'] as $product_id => $qty) {
        $stmtP = $pdo->prepare("SELECT precio FROM productos WHERE id = :id");
        $stmtP->execute([':id' => $product_id]);
        $prod = $stmtP->fetch(PDO::FETCH_ASSOC);
        $total += $prod['precio'] * $qty;
    }

    $stmt->execute([':usuario_id' => $_SESSION['usuario_id'], ':total' => $total]);
    $pedido_id = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $product_id => $qty) {
        $stmtP = $pdo->prepare("SELECT precio FROM productos WHERE id = :id");
        $stmtP->execute([':id' => $product_id]);
        $prod = $stmtP->fetch(PDO::FETCH_ASSOC);

        $stmtD = $pdo->prepare("INSERT INTO pedido_detalles (pedido_id, producto_id, cantidad, precio_unitario) VALUES (:pedido_id, :producto_id, :cantidad, :precio_unitario)");
        $stmtD->execute([
            ':pedido_id' => $pedido_id,
            ':producto_id' => $product_id,
            ':cantidad' => $qty,
            ':precio_unitario' => $prod['precio']
        ]);
    }

    $_SESSION['cart'] = [];
    echo "<h1>¡Pago exitoso!</h1>";
    echo "<p>Gracias por tu compra. Tu número de pedido es: <strong>#$pedido_id</strong></p>";
} else {
    echo "<p>No hay productos en tu carrito.</p>";
}

require_once '../includes/footer.php';
