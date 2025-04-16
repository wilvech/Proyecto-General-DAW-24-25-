<?php
session_start();
require_once '../includes/header.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') {
    exit("<p>No tienes permiso para acceder a esta sección.</p>");
}

// Eliminar mensaje
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM mensajes_contacto WHERE id = ?")->execute([(int)$_GET['delete']]);
    header('Location: manage_messages.php');
    exit;
}

$mensajes = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY fecha DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<main style="padding:20px;">
    <h1>Mensajes de Contacto</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Mensaje</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($mensajes as $m): ?>
            <tr>
                <td><?= $m['id'] ?></td>
                <td><?= htmlspecialchars($m['nombre']) ?></td>
                <td><?= htmlspecialchars($m['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($m['mensaje'])) ?></td>
                <td><?= $m['fecha'] ?></td>
                <td><a href="?delete=<?= $m['id'] ?>" class="btn" onclick="return confirm('¿Eliminar mensaje?')">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>

<?php require_once '../includes/footer.php'; ?>
