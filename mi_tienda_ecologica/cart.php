<?php
session_start();
require_once 'includes/header.php';

// Asegurarse de que la variable de carrito exista
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Procesar eliminación de producto cuando se envía el parámetro GET "delete"
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    if (isset($_SESSION['cart'][$delete_id])) {
        unset($_SESSION['cart'][$delete_id]);
        echo "<p>Producto eliminado del carrito.</p>";
    }
}

// Procesar la adición de producto si se reciben parámetros GET ("add" y "qty")
// (Si se agrega desde catalog.php)
if (isset($_GET['add'])) {
    $product_id = (int) $_GET['add'];
    $cantidadAgregar = isset($_GET['qty']) ? (int) $_GET['qty'] : 1;
    if ($cantidadAgregar < 1) {
        $cantidadAgregar = 1;
    }
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = $cantidadAgregar;
    } else {
        $_SESSION['cart'][$product_id] += $cantidadAgregar;
    }
    echo "<p>Producto añadido al carrito.</p>";
}

// Procesar la actualización de cantidades a través del formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['cantidad']) && is_array($_POST['cantidad'])) {
        foreach ($_POST['cantidad'] as $product_id => $new_qty) {
            $product_id = (int)$product_id;
            $new_qty = (int)$new_qty;
            if ($new_qty <= 0) {
                // Se elimina el producto si la cantidad es cero o menor
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id] = $new_qty;
            }
        }
        echo "<p>El carrito se ha actualizado.</p>";
    }
}
?>

<h1>Carrito</h1>

<?php if (!empty($_SESSION['cart'])): ?>
<form method="POST" action="">
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
            <td><?php echo htmlspecialchars($product['nombre']); ?></td>
            <td>
                <!-- Campo para modificar la cantidad -->
                <input type="number" min="0" name="cantidad[<?php echo $product_id; ?>]" 
                       value="<?php echo $qty; ?>" style="width:60px;">
            </td>
            <td>€<?php echo $product['precio']; ?></td>
            <td>€<?php echo $subtotal; ?></td>
            <td>
                <!-- Enlace para eliminar el producto -->
                <a href="cart.php?delete=<?php echo $product_id; ?>" class="btn">Eliminar</a>
            </td>
        </tr>
        <?php 
            endif;
        endforeach; 
        ?>
        <tr>
            <td colspan="3" style="text-align:right; font-weight:bold;">Total</td>
            <td style="font-weight:bold;">€<?php echo $total; ?></td>
            <td></td>
        </tr>
    </table>
    <!-- Contenedor común para ambos botones -->
    <div style="margin-top:20px; text-align:right;">
        <!-- Botón para actualizar el carrito -->
        <button type="submit" name="update_cart" class="btn" style="margin-right:10px;">Actualizar Carrito</button>
        <!-- Botón para proceder al pago -->
        <button type="button" onclick="window.location.href='checkout.php'" class="btn">Proceder al Pago</button>
    </div>
</form>
<?php else: ?>
    <p>El carrito está vacío.</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
