<?php
session_start();
require_once 'includes/header.php';

// Verificar que el usuario haya iniciado sesión
if(!isset($_SESSION['usuario_id'])){
    echo "<p>Debes iniciar sesión para proceder con la compra. <a href='login.php'>Login</a></p>";
    require_once 'includes/footer.php';
    exit;
}

// Verificar que el carrito no esté vacío
if(empty($_SESSION['cart'])){
    echo "<p>El carrito está vacío. <a href='catalog.php'>Volver al catálogo</a></p>";
    require_once 'includes/footer.php';
    exit;
}

// Calcular total de la compra
$total = 0;
foreach($_SESSION['cart'] as $product_id => $qty){
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->execute([':id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if($product){
        $subtotal = $product['precio'] * $qty;
        $total += $subtotal;
    }
}

// Simulación de pago: cuando se hace clic en el enlace de "Pagar"
if(isset($_GET['pay'])){
    // Insertar el pedido en la base de datos
    $sqlPedido = "INSERT INTO pedidos (usuario_id, fecha, total) VALUES (:usuario_id, NOW(), :total)";
    $stmtPedido = $pdo->prepare($sqlPedido);
    $stmtPedido->execute([
        ':usuario_id' => $_SESSION['usuario_id'],
        ':total' => $total
    ]);
    $pedido_id = $pdo->lastInsertId();

    // Insertar cada detalle del pedido
    foreach($_SESSION['cart'] as $product_id => $qty){
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute([':id' => $product_id]);
        $prod = $stmt->fetch(PDO::FETCH_ASSOC);

        $sqlDetalle = "INSERT INTO pedido_detalles (pedido_id, producto_id, cantidad, precio_unitario)
                       VALUES (:pedido_id, :producto_id, :cantidad, :precio_unitario)";
        $stmtDetalle = $pdo->prepare($sqlDetalle);
        $stmtDetalle->execute([
            ':pedido_id' => $pedido_id,
            ':producto_id' => $product_id,
            ':cantidad' => $qty,
            ':precio_unitario' => $prod['precio']
        ]);
    }

    // Vaciar carrito de la sesión
    $_SESSION['cart'] = [];

    echo "<p>¡Pago realizado con éxito! Tu pedido #{$pedido_id} ha sido procesado.</p>";
    require_once 'includes/footer.php';
    exit;
}
?>

<h1>Checkout</h1>
<p>Total a pagar: €<?php echo $total; ?></p>
<a href="checkout.php?pay=1" class="btn">Pagar ahora</a>

<?php
require_once 'includes/footer.php';
?>
