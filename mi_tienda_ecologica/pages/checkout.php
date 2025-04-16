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
<script src="https://js.stripe.com/v3/"></script>

<a href="stripe/checkout_session.php" class="btn">Pagar con Stripe</a>

<script>
const stripe = Stripe('pk_test_TU_CLAVE_PUBLICA'); // Reemplaza con tu clave pública

document.getElementById("checkout-button").addEventListener("click", async () => {
  const {token, error} = await stripe.createToken('card', {
    number: '4242424242424242',
    exp_month: 12,
    exp_year: 2025,
    cvc: '123'
  });

  if (token) {
    const res = await fetch('payment/charge.php', {
      method: 'POST',
      body: JSON.stringify({ token: token.id, amount: <?php echo $total * 100; ?> }) // en céntimos
    });

    const data = await res.json();
    if (data.success) {
      alert('Pago realizado correctamente');
      window.location.href = 'index.php';
    } else {
      alert('Error en el pago: ' + data.error);
    }
  } else {
    alert(error.message);
  }
});
</script>


<?php require_once '../includes/footer.php'; ?>
