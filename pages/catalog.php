<?php
require_once '../includes/header.php';

$categoriaSeleccionada = $_GET['categoria'] ?? '';

$stmtCategorias = $pdo->query("SELECT DISTINCT categoria FROM productos");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_COLUMN);

if ($categoriaSeleccionada != '') {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE categoria = :categoria");
    $stmt->execute([':categoria' => $categoriaSeleccionada]);
} else {
    $stmt = $pdo->query("SELECT * FROM productos");
}

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Catálogo de Productos</h1>

<div style="margin-bottom: 20px;">
    <?php foreach ($categorias as $cat): ?>
        <a href="?categoria=<?= urlencode($cat); ?>" class="btn"><?= htmlspecialchars($cat); ?></a>
    <?php endforeach; ?>
    <a href="catalog.php" class="btn">Ver Todas</a>
</div>

<div class="product-grid">
    <?php foreach ($productos as $prod): ?>
        <div class="product-item">
            <img src="<?= htmlspecialchars($prod['imagen']) ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>" />
            <h3><?= htmlspecialchars($prod['nombre']) ?></h3>
            <p>€<?= htmlspecialchars($prod['precio']) ?></p>
            <a href="cart.php?add=<?= $prod['id'] ?>" class="btn">Añadir al carrito</a>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../includes/footer.php'; ?>
