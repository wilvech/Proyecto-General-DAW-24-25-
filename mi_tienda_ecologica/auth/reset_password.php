<?php
require_once '../includes/header.php';

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['reset_tokens'][$token])) {
    $newPassword = $_POST['password'];
    $user_id = $_SESSION['reset_tokens'][$token]['user_id'];

    if (time() < $_SESSION['reset_tokens'][$token]['expires']) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
        $stmt->execute([':password' => $hash, ':id' => $user_id]);

        unset($_SESSION['reset_tokens'][$token]);
        echo "<p>Contraseña actualizada. <a href='login.php'>Inicia sesión</a></p>";
    } else {
        echo "<p>El token ha expirado.</p>";
    }
}
?>

<h1>Restablecer Contraseña</h1>
<form method="POST">
    <label>Nueva Contraseña: <input type="password" name="password" required></label><br><br>
    <button type="submit" class="btn">Actualizar</button>
</form>

<?php require_once '../includes/footer.php'; ?>
