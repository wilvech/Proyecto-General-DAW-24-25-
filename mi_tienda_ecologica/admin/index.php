<?php
require_once '../includes/header.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') {
    echo "<p>No tienes permiso para acceder a esta sección.</p>";
    require_once '../includes/footer.php';
    exit;
}
?>

<section class="admin-dashboard" style="padding: 40px 20px; text-align: center;">
    <h1 style="font-size: 2.5rem; color: #2f4f2f;">Panel de Administración</h1>
    <p style="font-size: 1.2rem; color: #555; margin-bottom: 30px;">
        Bienvenido, <?= htmlspecialchars($_SESSION['usuario_email']) ?>
    </p>
    <div class="admin-menu" style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
        <a href="manage_products.php" class="btn">Gestionar Productos</a>
        <a href="manage_orders.php" class="btn">Gestionar Pedidos</a>
        <a href="manage_users.php" class="btn">Gestionar Usuarios</a>
        <a href="manage_messages.php" class="btn">Mensajes de Contacto</a>
        <a href="../index.php" class="btn">Volver a la Tienda</a>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
