<?php
// Inicia la sesión si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_connect.php';
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="<?php echo BASE_URL; ?>">
            <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="Logo">
        </a>
    </div>
    <nav class="main-nav">
        <ul>
            <!-- Enlaces visibles siempre -->
            <li><a href="<?php echo BASE_URL; ?>/catalog.php">Productos</a></li>
            <li><a href="<?php echo BASE_URL; ?>/advanced_search.php">Búsqueda avanzada</a></li>

            <?php if (isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id'])): ?>
                <?php if ($_SESSION['usuario_rol'] === 'admin'): ?>
                    <!-- Opciones solo para administradores -->
                    <li><a href="<?php echo BASE_URL; ?>/admin/index.php">Menú Administrador</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/admin/manage_messages.php">Mensajes Contacto</a></li>
                <?php endif; ?>
                <li><a href="<?php echo BASE_URL; ?>/cart.php">Carrito</a></li>
                <li><a href="<?php echo BASE_URL; ?>/contact.php">Contacto</a></li>
                <li><a href="<?php echo BASE_URL; ?>/logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <!-- Opciones para usuarios no logueados -->
                <li><a href="<?php echo BASE_URL; ?>/register.php">Registro</a></li>
                <li><a href="<?php echo BASE_URL; ?>/login.php">Login</a></li>
                <li><a href="<?php echo BASE_URL; ?>/cart.php">Carrito</a></li>
                <li><a href="<?php echo BASE_URL; ?>/contact.php">Contacto</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
