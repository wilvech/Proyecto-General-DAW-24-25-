<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    exit("<p>No tienes permiso para acceder a esta sección.</p>");
}

// Eliminar mensaje
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM mensajes_contacto WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['delete']]);
    header('Location: manage_messages.php');
    exit;
}

// Consultar mensajes
$stmt = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY fecha DESC");
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../includes/header.php'; ?>

<main style="padding:20px;">
    <h1>Mensajes de Contacto</h1>

    <?php if ($mensajes): ?>
        <table border="1" cellpadding="10" cellspacing="0" style="width:100%;">
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
                    <td><?= htmlspecialchars($msg['id']) ?></td>
                    <td><?= htmlspecialchars($msg['nombre']) ?></td>
                    <td><?= htmlspecialchars($msg['email']) ?></td>
                    <td><?= nl2br(htmlspecialchars($msg['mensaje'])) ?></td>
                    <td><?= htmlspecialchars($msg['fecha']) ?></td>
                    <td>
                        <a href="?delete=<?= $msg['id'] ?>" class="btn" onclick="return confirm('¿Seguro que deseas borrar este mensaje?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay mensajes.</p>
    <?php endif; ?>
</main>

<?php require_once '../includes/footer.php'; ?>