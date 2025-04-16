<?php
require_once '../includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $product_id = (int)$_GET['add'];
    $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + 1;
}

if (isset($_GET['delete'])) {
    $product_id = (int)$_GET['delete'];
    unset($_SESSION['cart'][$product_id]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['cantidad'] as $product_id => $qty) {
        $product_id = (int)$product_id;
        $qty = (int)$qty;
        if ($qty <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $qty;
        }
    }
}
?>

<h1>Carrito</h1>

<?php if (!empty($_SESSION['cart'])): ?>
    <form method="POST">
        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $product_id => $qty):
                $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
                $stmt->execute([':id' => $product_id]);
                $prod = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$prod) continue;
                $subtotal = $prod['precio'] * $qty;
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($prod['nombre']) ?></td>
                <td><input type="number" name="cantidad[<?= $product_id ?>]" value="<?= $qty ?>" min="1" style="width:60px;"></td>
                <td>€<?= number_format($prod['precio'], 2) ?></td>
                <td>€<?= number_format($subtotal, 2) ?></td>
                <td><a href="?delete=<?= $product_id ?>" class="btn">Eliminar</a></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
                <td colspan="2"><strong>€<?= number_format($total, 2) ?></strong></td>
            </tr>
        </table>
        <button type="submit" name="update_cart" class="btn">Actualizar Carrito</button>
        <a href="checkout.php" class="btn">Proceder al Pago</a>
    </form>
<?php else: ?>
    <p>Tu carrito está vacío.</p>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
