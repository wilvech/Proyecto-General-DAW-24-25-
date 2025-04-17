<?php
session_start();
require_once '../includes/header.php';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_GET['add'])) {
    $product_id = (int) $_GET['add'];
    $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + 1;
}

if (isset($_GET['delete'])) {
    unset($_SESSION['cart'][(int) $_GET['delete']]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['cantidad'] as $id => $qty) {
        $id = (int) $id;
        $qty = (int) $qty;
        if ($qty <= 0) unset($_SESSION['cart'][$id]);
        else $_SESSION['cart'][$id] = $qty;
    }
}
?>

<h1>Carrito</h1>

<?php if (!empty($_SESSION['cart'])): ?>
<form method="POST">
    <table>
        <tr>
            <th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th><th>Acción</th>
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
            <td><?= $prod['nombre'] ?></td>
            <td><input type="number" name="cantidad[<?= $product_id ?>]" value="<?= $qty ?>" min="1" /></td>
            <td>€<?= $prod['precio'] ?></td>
            <td>€<?= $subtotal ?></td>
            <td><a href="?delete=<?= $product_id ?>" class="btn">Eliminar</a></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
            <td colspan="2"><strong>€<?= $total ?></strong></td>
        </tr>
    </table>
    <button type="submit" name="update_cart" class="btn">Actualizar</button>
    <a href="checkout.php" class="btn">Pagar</a>
</form>
<?php else: ?>
    <p>Tu carrito está vacío.</p>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
