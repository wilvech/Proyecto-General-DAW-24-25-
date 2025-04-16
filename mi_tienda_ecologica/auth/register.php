<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';
?>

<h1>Registro de Usuario</h1>

<form method="POST" action="../api/routes/auth.php?action=register">
    <label>Nombre: <input type="text" name="nombre" required></label>
    <label>Email: <input type="email" name="email" required></label>
    <label>Contraseña: <input type="password" name="password" required></label>
    <label>Dirección: <input type="text" name="direccion"></label>
    <label>Teléfono: <input type="text" name="telefono"></label>
    <button type="submit" class="btn">Registrar</button>
</form>

<p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>

<?php require_once '../includes/footer.php'; ?>
