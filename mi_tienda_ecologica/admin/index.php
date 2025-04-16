<?php
session_start();
require_once '../includes/config.php';

// Verificar que el usuario esté logueado y sea administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    echo "<p>No tienes permisos para acceder a esta sección.</p>";
    exit;
}

require_once '../includes/header.php';
?>

<!-- Contenedor principal del Panel de Administración -->
<section class="admin-dashboard" style="padding: 40px 20px; text-align: center;">
    <h1 style="font-size: 2.5rem; color: #2f4f2f;">Panel de Administración</h1>
    <p style="font-size: 1.2rem; color: #555; margin-bottom: 30px;">
        Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_email']); ?>
    </p>
    <div class="admin-menu" style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
        <a href="manage_products.php" class="btn" style="padding: 10px 20px;">Gestionar Productos</a>
        <a href="manage_orders.php" class="btn" style="padding: 10px 20px;">Gestionar Pedidos</a>
        <a href="../index.php" class="btn" style="padding: 10px 20px;">Volver a la Tienda</a>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>
