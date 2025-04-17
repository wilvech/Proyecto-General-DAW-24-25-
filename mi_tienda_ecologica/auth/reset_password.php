<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';

$token = $_GET['token'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM tokens WHERE token = :token AND expires_at > NOW()");
$stmt->execute([':token' => $token]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "<p>Token inválido o expirado.</p>";
    require_once '../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id")
        ->execute([':password' => $newPassword, ':id' => $data['usuario_id']]);

    $pdo->prepare("DELETE FROM tokens WHERE token = :token")->execute([':token' => $token]);

    $_SESSION['flash_success'] = "Contraseña actualizada. Inicia sesión.";
    header('Location: login.php');
    exit;
}
?>

<h1>Restablecer Contraseña</h1>

<form method="POST">
    <label>Nueva Contraseña: <input type="password" name="password" required></label>
    <button type="submit" class="btn">Actualizar</button>
</form>

<?php require_once '../includes/footer.php'; ?>
