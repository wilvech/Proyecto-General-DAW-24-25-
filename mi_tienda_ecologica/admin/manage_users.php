<?php
session_start();
require_once '../includes/header.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') {
    exit("<p>No tienes permiso para acceder a esta sección.</p>");
}

// Actualizar rol
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['rol'])) {
    $stmt = $pdo->prepare("UPDATE usuarios SET rol = :rol WHERE id = :id");
    $stmt->execute([
        ':rol' => $_POST['rol'],
        ':id' => $_POST['user_id']
    ]);
}

// Eliminar usuario
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM usuarios WHERE id = ?")->execute([(int)$_GET['delete']]);
    header('Location: manage_users.php');
    exit;
}

$usuarios = $pdo->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<main style="padding: 20px;">
    <h1>Gestionar Usuarios</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['nombre']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                        <select name="rol">
                            <option value="cliente" <?= $u['rol'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                            <option value="admin" <?= $u['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                        <button type="submit" class="btn">Actualizar</button>
                    </form>
                </td>
                <td>
                    <a href="?delete=<?= $u['id'] ?>" class="btn" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>

<?php require_once '../includes/footer.php'; ?>
