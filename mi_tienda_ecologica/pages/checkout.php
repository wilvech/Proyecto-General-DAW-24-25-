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
    $prod = $stmt->fetch();
    $total += $prod['precio'] * $qty;
}
?>

<h1>Resumen de Compra</h1>
<p>Total a pagar: <strong>€<?= number_format($total, 2) ?></strong></p>

<a href="../stripe/checkout_session.php" class="btn">Pagar con Stripe</a>

<?php require_once '../includes/footer.php'; ?>
