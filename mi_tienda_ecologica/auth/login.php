<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';
?>

<h1>Iniciar Sesión</h1>

<form method="POST" action="../api/routes/auth.php?action=login">
    <label>Email: <input type="email" name="email" required></label>
    <label>Contraseña: <input type="password" name="password" required></label>
    <button type="submit" class="btn">Entrar</button>
</form>

<p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
<p>¿Olvidaste tu contraseña? <a href="forgot_password.php">Recupérala aquí</a></p>

<?php require_once '../includes/footer.php'; ?>
