<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';
?>

<h1>Recuperar Contraseña</h1>

<form method="POST" action="../api/routes/auth.php?action=forgot">
    <label>Email: <input type="email" name="email" required></label>
    <button type="submit" class="btn">Enviar enlace de recuperación</button>
</form>

<p><a href="login.php">Volver al login</a></p>

<?php require_once '../includes/footer.php'; ?>
