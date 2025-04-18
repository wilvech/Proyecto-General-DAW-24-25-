<?php
require_once '../includes/header.php';
require_once '../includes/config.php';
require_once '../components/flash_message.php';

$token = $_GET['token'] ?? '';

if (!$token) {
    echo "<p style='color:red'>Token no proporcionado.</p>";
    require_once '../includes/footer.php';
    exit;
}

// Verificar que el token exista y no haya expirado
$stmt = $pdo->prepare("SELECT * FROM tokens WHERE token = :token AND expires_at > NOW()");
$stmt->execute([':token' => $token]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "<p style='color:red'>Token inválido o expirado.</p>";
    require_once '../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (strlen($newPassword) < 6) {
        $_SESSION['flash_error'] = "La contraseña debe tener al menos 6 caracteres.";
    } elseif ($newPassword !== $confirmPassword) {
        $_SESSION['flash_error'] = "Las contraseñas no coinciden.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Actualizar contraseña
        $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id")
            ->execute([
                ':password' => $hashedPassword,
                ':id' => $data['usuario_id']
            ]);

        // Eliminar el token usado
        $pdo->prepare("DELETE FROM tokens WHERE token = :token")->execute([':token' => $token]);

        $_SESSION['flash_success'] = "Contraseña actualizada correctamente. Ahora puedes iniciar sesión.";
        header('Location: login.php');
        exit;
    }
}
?>

<h1>Restablecer Contraseña</h1>
<?php include_once '../components/flash_message.php'; ?>

<form method="POST">
    <label for="password">Nueva Contraseña:</label>
    <div class="password-container">
        <input type="password" name="password" id="password" required>
        <img id="icono-ojo1" class="toggle-password-img"
             src="<?php echo BASE_URL; ?>/assets/images/eye-closed.png"
             alt="Mostrar contraseña"
             onmousedown="mostrarPassword('password', 'icono-ojo1')"
             onmouseup="ocultarPassword('password', 'icono-ojo1')"
             onmouseleave="ocultarPassword('password', 'icono-ojo1')">
    </div>
    <br>

    <label for="confirm_password">Confirmar Contraseña:</label>
    <div class="password-container">
        <input type="password" name="confirm_password" id="confirm_password" required>
        <img id="icono-ojo2" class="toggle-password-img"
             src="<?php echo BASE_URL; ?>/assets/images/eye-closed.png"
             alt="Mostrar contraseña"
             onmousedown="mostrarPassword('confirm_password', 'icono-ojo2')"
             onmouseup="ocultarPassword('confirm_password', 'icono-ojo2')"
             onmouseleave="ocultarPassword('confirm_password', 'icono-ojo2')">
    </div>

    <br><button type="submit" class="btn">Actualizar</button>
</form>

<!-- JavaScript para ambas contraseñas -->
<script>
function mostrarPassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icono = document.getElementById(iconId);
    input.type = "text";
    icono.src = "<?php echo BASE_URL; ?>/assets/images/eye-open.png";
}

function ocultarPassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icono = document.getElementById(iconId);
    input.type = "password";
    icono.src = "<?php echo BASE_URL; ?>/assets/images/eye-closed.png";
}
</script>

<?php require_once '../includes/footer.php'; ?>
