<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/config.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') {
    exit("<p>No tienes permisos para acceder a esta sección.</p>");
}

// Actualizar estado del pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $pedido_id = (int)$_POST['pedido_id'];
    $nuevo_estado = $_POST['estado'];

    $stmt = $pdo->prepare("UPDATE pedidos SET estado = :estado WHERE id = :id");
    $stmt->execute([':estado' => $nuevo_estado, ':id' => $pedido_id]);
}

// Eliminar pedido
if (isset($_GET['delete'])) {
    $pedido_id = (int)$_GET['delete'];

    $stmtDetalles = $pdo->prepare("DELETE FROM pedido_detalles WHERE pedido_id = :pedido_id");
    $stmtDetalles->execute([':pedido_id' => $pedido_id]);

    $stmtPedido = $pdo->prepare("DELETE FROM pedidos WHERE id = :id");
    $stmtPedido->execute([':id' => $pedido_id]);

    header("Location: manage_orders.php");
    exit;
}

// Obtener pedidos
$stmt = $pdo->query("SELECT * FROM pedidos ORDER BY fecha DESC");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../includes/header.php'; ?>

<main style="padding: 20px;">
    <h1>Gestionar Pedidos</h1>

    <?php if (count($pedidos) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0" style="width:100%; margin-bottom:20px;">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Productos</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido['id']; ?></td>
                    <td>
                        <?php
                        $stmtUser = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = :id");
                        $stmtUser->execute([':id' => $pedido['usuario_id']]);
                        $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);
                        echo htmlspecialchars($usuario['nombre'] ?? 'Desconocido');
                        ?>
                    </td>
                    <td><?= $pedido['fecha']; ?></td>
                    <td><?= $pedido['total']; ?>€</td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="pedido_id" value="<?= $pedido['id']; ?>">
                            <select name="estado">
                                <option value="pendiente" <?= $pedido['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="pagado" <?= $pedido['estado'] === 'pagado' ? 'selected' : ''; ?>>Pagado</option>
                                <option value="enviado" <?= $pedido['estado'] === 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                            </select>
                            <button type="submit" name="update_status" class="btn">Actualizar</button>
                        </form>
                    </td>
                    <td>
                        <?php
                        $stmtDetalle = $pdo->prepare("SELECT p.nombre, pd.cantidad FROM pedido_detalles pd
                                                      JOIN productos p ON pd.producto_id = p.id
                                                      WHERE pd.pedido_id = :pedido_id");
                        $stmtDetalle->execute([':pedido_id' => $pedido['id']]);
                        $detalles = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);
                        echo "<ul style='list-style:none; padding:0;'>";
                        foreach ($detalles as $detalle) {
                            echo "<li>" . htmlspecialchars($detalle['nombre']) . " x " . $detalle['cantidad'] . "</li>";
                        }
                        echo "</ul>";
                        ?>
                    </td>
                    <td>
                        <a href="?delete=<?= $pedido['id']; ?>" class="btn" onclick="return confirm('¿Eliminar este pedido?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay pedidos aún.</p>
    <?php endif; ?>

    <a href="index.php" class="btn">Volver al Panel</a>
</main>

<?php require_once '../includes/footer.php'; ?>
