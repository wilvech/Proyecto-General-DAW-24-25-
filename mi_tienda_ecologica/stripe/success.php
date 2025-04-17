<?php
session_start();
require_once '../includes/header.php';

if (!isset($_SESSION['usuario_id']) || empty($_SESSION['cart'])) {
    echo "<p>No hay productos para procesar.</p>";
    require_once '../includes/footer.php';
    exit;
}

require_once '../includes/db_connect.php';

$total = 0;
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = :id");
    $stmt->execute([':id' => $product_id]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);
    $total += $prod['precio'] * $qty;
}

// Insertar pedido
$stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (:usuario_id, :total)");
$stmt->execute([':usuario_id' => $_SESSION['usuario_id'], ':total' => $total]);
$pedido_id = $pdo->lastInsertId();

// Insertar detalles
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = :id");
    $stmt->execute([':id' => $product_id]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmtInsert = $pdo->prepare("INSERT INTO pedido_detalles (pedido_id, producto_id, cantidad, precio_unitario)
                                VALUES (:pedido_id, :producto_id, :cantidad, :precio)");
    $stmtInsert->execute([
        ':pedido_id' => $pedido_id,
        ':producto_id' => $product_id,
        ':cantidad' => $qty,
        ':precio' => $prod['precio']
    ]);
}

$_SESSION['cart'] = [];
?>

<h1>¡Pago exitoso!</h1>
<p>Gracias por tu compra. Tu pedido #<?= $pedido_id ?> ha sido registrado correctamente.</p>
<a href="<?= BASE_URL ?>/pages/catalog.php" class="btn">Seguir comprando</a>

<?php require_once '../includes/footer.php'; ?>
