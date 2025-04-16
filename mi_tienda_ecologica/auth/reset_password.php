<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';

$token = $_GET['token'] ?? '';
?>

<h1>Restablecer Contraseña</h1>

<form method="POST" action="../api/routes/auth.php?action=reset&token=<?php echo urlencode($token); ?>">
    <label>Nueva Contraseña: <input type="password" name="password" required></label>
    <button type="submit" class="btn">Actualizar contraseña</button>
</form>

<?php require_once '../includes/footer.php'; ?>
