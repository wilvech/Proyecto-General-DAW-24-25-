<?php
session_start();
require_once '../includes/header.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') {
    exit("<p>No tienes permisos para acceder a esta sección.</p>");
}

// Cambiar estado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'], $_POST['estado'])) {
    $stmt = $pdo->prepare("UPDATE pedidos SET estado = :estado WHERE id = :id");
    $stmt->execute([
        ':estado' => $_POST['estado'],
        ':id' => $_POST['pedido_id']
    ]);
}

// Eliminar pedido (y detalles primero)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM pedido_detalles WHERE pedido_id = :id")->execute([':id' => $id]);
    $pdo->prepare("DELETE FROM pedidos WHERE id = :id")->execute([':id' => $id]);
    header('Location: manage_orders.php');
    exit;
}

$pedidos = $pdo->query("SELECT * FROM pedidos ORDER BY fecha DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<main style="padding:20px;">
    <h1>Gestionar Pedidos</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Detalles</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td>
                    <?php
                    $u = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = ?");
                    $u->execute([$p['usuario_id']]);
                    echo $u->fetchColumn();
                    ?>
                </td>
                <td><?= $p['fecha'] ?></td>
                <td>€<?= $p['total'] ?></td>
                <td><?= $p['estado'] ?></td>
                <td>
                    <?php
                    $det = $pdo->prepare("SELECT pd.cantidad, p.nombre FROM pedido_detalles pd JOIN productos p ON p.id = pd.producto_id WHERE pd.pedido_id = ?");
                    $det->execute([$p['id']]);
                    foreach ($det->fetchAll() as $d) {
                        echo $d['nombre'] . ' x ' . $d['cantidad'] . '<br>';
                    }
                    ?>
                </td>
                <td>
                    <form method="POST" style="margin-bottom:5px;">
                        <input type="hidden" name="pedido_id" value="<?= $p['id'] ?>">
                        <select name="estado">
                            <option value="pendiente" <?= $p['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="pagado" <?= $p['estado'] === 'pagado' ? 'selected' : '' ?>>Pagado</option>
                            <option value="enviado" <?= $p['estado'] === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                        </select>
                        <button type="submit" class="btn">Actualizar</button>
                    </form>
                    <a href="?delete=<?= $p['id'] ?>" class="btn" onclick="return confirm('¿Eliminar este pedido?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>

<?php require_once '../includes/footer.php'; ?>
