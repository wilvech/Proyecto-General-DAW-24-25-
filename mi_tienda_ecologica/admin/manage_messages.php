<?php
require_once '../includes/header.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') {
    echo "<p>No tienes permiso para acceder a esta sección.</p>";
    require_once '../includes/footer.php';
    exit;
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM mensajes_contacto WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['delete']]);
    header('Location: manage_messages.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY fecha DESC");
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main style="padding:20px;">
    <h1>Mensajes de Contacto</h1>
    <?php if ($mensajes): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($mensajes as $msg): ?>
                <tr>
                    <td><?= $msg['id'] ?></td>
                    <td><?= htmlspecialchars($msg['nombre']) ?></td>
                    <td><?= htmlspecialchars($msg['email']) ?></td>
                    <td><?= nl2br(htmlspecialchars($msg['mensaje'])) ?></td>
                    <td><?= $msg['fecha'] ?></td>
                    <td><a href="?delete=<?= $msg['id'] ?>" onclick="return confirm('¿Eliminar este mensaje?');" class="btn">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay mensajes.</p>
    <?php endif; ?>
</main>

<?php require_once '../includes/footer.php'; ?>
