<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/config.php';

// Verificar que el usuario esté logueado y sea administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    exit("<p>No tienes permisos para acceder a esta sección.</p>");
}

// Actualizar estado del pedido
if (isset($_POST['update_status'])) {
    $pedido_id = (int)$_POST['pedido_id'];
    $nuevo_estado = $_POST['estado'];

    $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':estado' => $nuevo_estado,
        ':id' => $pedido_id
    ]);
}

// Procesar eliminación del pedido (con corrección del error Foreign Key)
if (isset($_GET['delete'])) {
    $pedido_id = (int)$_GET['delete'];

    // Primero eliminar detalles del pedido
    $stmtDetalles = $pdo->prepare("DELETE FROM pedido_detalles WHERE pedido_id = :pedido_id");
    $stmtDetalles->execute([':pedido_id' => $pedido_id]);

    // Ahora eliminar el pedido principal
    $stmtPedido = $pdo->prepare("DELETE FROM pedidos WHERE id = :id");
    if ($stmtPedido->execute([':id' => $pedido_id])) {
        header("Location: manage_orders.php");
        exit;
    } else {
        exit("<p>Error al eliminar el pedido.</p>");
    }
}

// Consultar la lista de pedidos
$stmt = $pdo->query("SELECT * FROM pedidos ORDER BY fecha DESC");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../includes/header.php'; ?>

<main style="padding:20px;">
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
                    <td><?= htmlspecialchars($pedido['id']); ?></td>
                    <td>
                        <?php
                        // Obtener el nombre del usuario a partir de usuario_id
                        $stmtUser = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = :id");
                        $stmtUser->execute([':id' => $pedido['usuario_id']]);
                        $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);
                        echo htmlspecialchars($usuario['nombre'] ?? 'Desconocido');
                        ?>
                    </td>
                    <td><?= htmlspecialchars($pedido['fecha']); ?></td>
                    <td><?= htmlspecialchars($pedido['total']); ?>€</td>
                    <td><?= htmlspecialchars($pedido['estado']); ?></td>
                    <td>
                        <?php
                        // Obtener los productos del pedido actual
                        $stmtDetails = $pdo->prepare("SELECT pd.cantidad, p.nombre FROM pedido_detalles pd JOIN productos p ON pd.producto_id = p.id WHERE pd.pedido_id = :pedido_id");
                        $stmtDetails->execute([':pedido_id' => $pedido['id']]);
                        $detalles = $stmtDetails->fetchAll(PDO::FETCH_ASSOC);
                        if ($detalles):
                            echo "<ul style='list-style:none;padding:0;'>";
                            foreach ($detalles as $detalle) {
                                echo "<li>" . htmlspecialchars($detalle['nombre']) . " x " . htmlspecialchars($detalle['cantidad']) . "</li>";
                            }
                            echo "</ul>";
                        else:
                            echo "No hay detalles.";
                        endif;
                        ?>
                    </td>
                    <td>
                        <!-- Actualizar estado -->
                        <form method="POST" style="margin-bottom:5px;">
                            <input type="hidden" name="pedido_id" value="<?= $pedido['id']; ?>">
                            <select name="estado">
                                <option value="pendiente" <?= $pedido['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="pagado" <?= $pedido['estado'] === 'pagado' ? 'selected' : ''; ?>>Pagado</option>
                                <option value="enviado" <?= $pedido['estado'] === 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                            </select>
                            <button type="submit" name="update_status" class="btn">Actualizar</button>
                        </form>

                        <!-- Eliminar pedido -->
                        <a href="?delete=<?= $pedido['id']; ?>" class="btn" onclick="return confirm('¿Seguro que deseas eliminar este pedido?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay pedidos.</p>
    <?php endif; ?>

    <a href="index.php" class="btn">Volver al Panel de Administración</a>
</main>

<?php require_once '../includes/footer.php'; ?>