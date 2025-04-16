<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM tokens WHERE token = :token AND expires_at > NOW()");
    $stmt->execute([':token' => $token]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $stmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
        $stmt->execute([
            ':password' => $newPassword,
            ':id' => $data['usuario_id']
        ]);

        $stmt = $pdo->prepare("DELETE FROM tokens WHERE id = :id");
        $stmt->execute([':id' => $data['id']]);

        $_SESSION['flash_success'] = 'Contraseña restablecida correctamente.';
        header('Location: login.php');
        exit;
    } else {
        $_SESSION['flash_error'] = 'Token inválido o expirado.';
    }
}
?>

<h1>Restablecer Contraseña</h1>

<form method="POST">
    <label>Nueva Contraseña: <input type="password" name="password" required></label>
    <button type="submit" class="btn">Actualizar contraseña</button>
</form>

<?php require_once '../includes/footer.php'; ?>
