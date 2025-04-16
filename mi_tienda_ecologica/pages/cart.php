<?php
session_start();
require_once '../includes/header.php';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    unset($_SESSION['cart'][$delete_id]);
}

if (isset($_GET['add'])) {
    $product_id = (int) $_GET['add'];
    $qty = isset($_GET['qty']) ? (int) $_GET['qty'] : 1;
    $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + $qty;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['cantidad'] as $product_id => $new_qty) {
        $product_id = (int)$product_id;
        $new_qty = (int)$new_qty;
        if ($new_qty <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $new_qty;
        }
    }
}
?>

<h1>Carrito</h1>

<?php if (!empty($_SESSION['cart'])): ?>
    <form method="POST">
        <table border="1" cellpadding="10" cellspacing="0" style="width:100%; margin-bottom:20px;">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $product_id => $qty):
                $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
                $stmt->execute([':id' => $product_id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($product):
                    $subtotal = $product['precio'] * $qty;
                    $total += $subtotal;
            ?>
                    <tr>
                        <td><?= htmlspecialchars($product['nombre']) ?></td>
                        <td><input type="number" name="cantidad[<?= $product_id ?>]" value="<?= $qty ?>" min="1" style="width:60px;"></td>
                        <td>€<?= $product['precio'] ?></td>
                        <td>€<?= $subtotal ?></td>
                        <td><a href="?delete=<?= $product_id ?>" class="btn">Eliminar</a></td>
                    </tr>
            <?php endif;
            endforeach; ?>
            <tr>
                <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
                <td colspan="2"><strong>€<?= $total ?></strong></td>
            </tr>
        </table>
        <button type="submit" name="update_cart" class="btn">Actualizar Carrito</button>
        <a href="checkout.php" class="btn">Proceder al Pago</a>
    </form>
<?php else: ?>
    <p>Tu carrito está vacío.</p>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>