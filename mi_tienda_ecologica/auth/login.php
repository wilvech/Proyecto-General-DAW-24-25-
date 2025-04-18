<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_email'] = $user['email'];
        $_SESSION['usuario_rol'] = $user['rol'];
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['flash_error'] = "Credenciales inválidas.";
    }
}
?>

<h1>Iniciar Sesión</h1>

<form method="POST">
    <label>Email:</label>
    <input type="email" name="email" required>

    <label for="password">Contraseña:</label>
<div class="password-container">
    <input type="password" name="password" id="password" required>
    <img id="icono-ojo" class="toggle-password-img"
         src="<?php echo BASE_URL; ?>/assets/images/eye-closed.png"
         alt="Mostrar contraseña"
         onmousedown="mostrarPassword()"
         onmouseup="ocultarPassword()"
         onmouseleave="ocultarPassword()">
</div>




    <button type="submit" class="btn">Entrar</button>
</form>

<p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
<p>¿Olvidaste tu contraseña? <a href="forgot_password.php">Recupérala aquí</a></p>

<!-- JavaScript para mostrar/ocultar contraseña -->
<script>
function mostrarPassword() {
    const passwordInput = document.getElementById("password");
    const iconoOjo = document.getElementById("icono-ojo");

    passwordInput.type = "text";
    iconoOjo.src = "<?php echo BASE_URL; ?>/assets/images/eye-open.png";
}

function ocultarPassword() {
    const passwordInput = document.getElementById("password");
    const iconoOjo = document.getElementById("icono-ojo");

    passwordInput.type = "password";
    iconoOjo.src = "<?php echo BASE_URL; ?>/assets/images/eye-closed.png";
}
</script>
