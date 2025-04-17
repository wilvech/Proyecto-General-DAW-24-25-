<?php
require_once '../includes/header.php';
require_once '../includes/sendEmail.php';
require_once '../components/flash_message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 3600);

        $pdo->prepare("INSERT INTO tokens (usuario_id, token, expires_at) VALUES (:user_id, :token, :expires)")
            ->execute([':user_id' => $user['id'], ':token' => $token, ':expires' => $expires]);

        $resetUrl = BASE_URL . "/auth/reset_password.php?token=$token";
        $subject = "Recuperación de contraseña";
        $message = "Haz clic en este enlace para restablecer tu contraseña: <a href='$resetUrl'>$resetUrl</a>";

        if (sendEmail($email, 'Soporte Tienda', $subject, $message)) {
            $_SESSION['flash_success'] = "Se ha enviado un enlace de recuperación a tu correo.";
        } else {
            $_SESSION['flash_error'] = "Error al enviar el correo.";
        }
    } else {
        $_SESSION['flash_error'] = "No se encontró ese correo.";
    }
}
?>

<h1>Recuperar Contraseña</h1>

<form method="POST">
    <label>Email: <input type="email" name="email" required></label>
    <button type="submit" class="btn">Enviar enlace</button>
</form>

<p><a href="login.php">Volver al login</a></p>

<?php require_once '../includes/footer.php'; ?>
