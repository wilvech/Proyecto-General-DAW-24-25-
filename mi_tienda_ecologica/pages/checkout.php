<?php
session_start();
require_once '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Debes iniciar sesión para continuar. <a href='../auth/login.php'>Iniciar sesión</a></p>";
    require_once '../includes/footer.php';
    exit;
}

if (empty($_SESSION['cart'])) {
    echo "<p>Tu carrito está vacío.</p>";
    require_once '../includes/footer.php';
    exit;
}

$total = 0;
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = :id");
    $stmt->execute([':id' => $product_id]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);
    $total += $prod['precio'] * $qty;
}

if (isset($_GET['pay'])) {
    $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, fecha, total) VALUES (:usuario_id, NOW(), :total)");
    $stmt->execute([':usuario_id' => $_SESSION['usuario_id'], ':total' => $total]);
    $pedido_id = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $product_id => $qty) {
        $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = :id");
        $stmt->execute([':id' => $product_id]);
        $prod = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmtInsert = $pdo->prepare("INSERT INTO pedido_detalles (pedido_id, producto_id, cantidad, precio_unitario) VALUES (:pedido_id, :producto_id, :cantidad, :precio)");
        $stmtInsert->execute([
            ':pedido_id' => $pedido_id,
            ':producto_id' => $product_id,
            ':cantidad' => $qty,
            ':precio' => $prod['precio']
        ]);
    }

    $_SESSION['cart'] = [];
    echo "<p>¡Pago procesado correctamente! Tu número de pedido es: #{$pedido_id}</p>";
    require_once '../includes/footer.php';
    exit;
}
?>

<h1>Resumen de Compra</h1>
<p>Total a pagar: <strong>€<?= $total ?></strong></p>
<a href="checkout.php?pay=1" class="btn">Pagar ahora</a>

<?php require_once '../includes/footer.php'; ?>
