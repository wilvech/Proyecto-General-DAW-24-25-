<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_connect.php';
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Ecológica</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body>
<header>
    <div class="logo">
        <a href="<?php echo BASE_URL; ?>/index.php">
            <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="Logo">
        </a>
    </div>
    <nav class="main-nav">
        <ul>
            <li><a href="<?php echo BASE_URL; ?>/pages/catalog.php">Catálogo</a></li>
            <li><a href="<?php echo BASE_URL; ?>/pages/advanced_search.php">Buscar</a></li>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <?php if ($_SESSION['usuario_rol'] === 'admin'): ?>
                    <li><a href="<?php echo BASE_URL; ?>/admin/index.php">Admin</a></li>
                <?php endif; ?>
                <li><a href="<?php echo BASE_URL; ?>/pages/cart.php">Carrito</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/contact.php">Contacto</a></li>
                <li><a href="<?php echo BASE_URL; ?>/auth/logout.php">Salir</a></li>
            <?php else: ?>
                <li><a href="<?php echo BASE_URL; ?>/auth/register.php">Registro</a></li>
                <li><a href="<?php echo BASE_URL; ?>/auth/login.php">Login</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/cart.php">Carrito</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/contact.php">Contacto</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
