<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 3600);

        $stmt = $pdo->prepare("INSERT INTO tokens (usuario_id, token, expires_at) VALUES (:usuario_id, :token, :expires_at)");
        $stmt->execute([
            ':usuario_id' => $user['id'],
            ':token' => $token,
            ':expires_at' => $expires
        ]);

        $link = BASE_URL . "/auth/reset_password.php?token=$token";
        $to = $email;
        $subject = "Recuperación de contraseña";
        $message = "Haz clic aquí para recuperar tu contraseña: <a href='$link'>$link</a>";

        require_once '../vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ecotiendatest@gmail.com';
            $mail->Password = '1234,Abcd';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('ecotiendatest@gmail.com', 'Tienda Ecológica');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();

            $_SESSION['flash_success'] = 'Correo enviado. Revisa tu bandeja de entrada.';
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error al enviar el correo. Intenta más tarde.';
        }
    } else {
        $_SESSION['flash_error'] = 'No se encontró ese correo.';
    }
}
?>

<h1>Recuperar Contraseña</h1>

<form method="POST">
    <label>Email: <input type="email" name="email" required></label>
    <button type="submit" class="btn">Enviar enlace de recuperación</button>
</form>

<p><a href="login.php">Volver al login</a></p>

<?php require_once '../includes/footer.php'; ?>
