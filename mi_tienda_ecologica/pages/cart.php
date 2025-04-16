<?php
session_start();
require_once '../includes/header.php';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_GET['delete'])) {
    unset($_SESSION['cart'][(int) $_GET['delete']]);
}

if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['cantidad'] as $id => $cantidad) {
        if ($cantidad <= 0) unset($_SESSION['cart'][(int)$id]);
        else $_SESSION['cart'][(int)$id] = (int)$cantidad;
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
                <th>Acciones</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $qty):
                $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
                $stmt->execute([$id]);
                $producto = $stmt->fetch();
                $subtotal = $producto['precio'] * $qty;
                $total += $subtotal;
            ?>
            <tr>
                <td><?= $producto['nombre'] ?></td>
                <td><input type="number" name="cantidad[<?= $id ?>]" value="<?= $qty ?>" min="1" style="width:60px;"></td>
                <td>€<?= $producto['precio'] ?></td>
                <td>€<?= $subtotal ?></td>
                <td><a href="?delete=<?= $id ?>" class="btn">Eliminar</a></td>
            </tr>
            <?php endforeach; ?>
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
