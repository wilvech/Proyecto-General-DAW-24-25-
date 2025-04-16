<?php
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    // Buscar al usuario
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token = bin2hex(random_bytes(16));
        $_SESSION['reset_tokens'][$token] = [
            'user_id' => $user['id'],
            'expires' => time() + 3600
        ];

        $link = BASE_URL . "/auth/reset_password.php?token=$token";
        echo "<p>Enlace generado: <a href='$link'>$link</a></p>";
    } else {
        echo "<p style='color:red;'>Correo no encontrado.</p>";
    }
}
?>

<h1>Recuperar Contraseña</h1>
<form method="POST">
    <label>Email: <input type="email" name="email" required></label><br><br>
    <button type="submit" class="btn">Enviar enlace</button>
</form>
<p><a href="login.php">Volver al login</a></p>

<?php require_once '../includes/footer.php'; ?>
