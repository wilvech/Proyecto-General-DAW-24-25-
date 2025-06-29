<?php
session_start();
require_once '../includes/header.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso denegado. <a href='../auth/login.php'>Inicia sesión</a></p>";
    require_once '../includes/footer.php';
    exit;
}
?>

<h1>Panel del Usuario</h1>
<p>Bienvenido/a, <?= htmlspecialchars($_SESSION['usuario_email']) ?></p>
<p>Desde aquí puedes gestionar tu perfil y ver el catálogo.</p>

<a href="profile.php" class="btn">Ver Perfil</a>
<a href="catalog.php" class="btn">Ir al Catálogo</a>

<?php require_once '../includes/footer.php'; ?>
