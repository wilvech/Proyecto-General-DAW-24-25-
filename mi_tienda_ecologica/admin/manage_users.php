<?php
require_once '../includes/header.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') {
    echo "<p>No tienes permiso para acceder a esta sección.</p>";
    require_once '../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['rol'])) {
    $stmt = $pdo->prepare("UPDATE usuarios SET rol = :rol WHERE id = :id");
    $stmt->execute([
        ':rol' => $_POST['rol'],
        ':id' => $_POST['user_id']
    ]);
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $_GET['delete']]);
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
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario['id'] ?></td>
                <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?= $usuario['id'] ?>">
                        <select name="rol">
                            <option value="cliente" <?= $usuario['rol'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                            <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                        <button type="submit" class="btn">Actualizar</button>
                    </form>
                </td>
                <td><a href="?delete=<?= $usuario['id'] ?>" onclick="return confirm('¿Eliminar este usuario?');" class="btn">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php" class="btn">Volver al Panel</a>
</main>

<?php require_once '../includes/footer.php'; ?>
