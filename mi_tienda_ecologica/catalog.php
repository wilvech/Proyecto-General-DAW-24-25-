<?php
require_once 'includes/header.php';

// Obtenemos la categoría seleccionada desde la URL
$categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Consultamos todas las categorías únicas
$stmtCategorias = $pdo->query("SELECT DISTINCT categoria FROM productos");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_COLUMN);

// Filtramos productos por categoría si está seleccionada
if ($categoriaSeleccionada != '') {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE categoria = :categoria");
    $stmt->execute([':categoria' => $categoriaSeleccionada]);
} else {
    $stmt = $pdo->query("SELECT * FROM productos");
}

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Catálogo de Productos</h1>

<!-- Sección de Categorías -->
<div style="margin-bottom: 20px;">
    <?php foreach ($categorias as $cat): ?>
        <a href="?categoria=<?php echo urlencode($cat); ?>" class="btn"><?php echo htmlspecialchars($cat); ?></a>
    <?php endforeach; ?>
    <a href="catalog.php" class="btn">Ver Todas</a>
</div>

<!-- Grid de Productos -->
<div class="product-grid">
    <?php foreach($productos as $prod): ?>
    <div class="product-item">
        <img src="<?php echo BASE_URL.'/assets/images/productos/'.$prod['imagen']; ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>" />
        <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
        <p>€<?php echo htmlspecialchars($prod['precio']); ?></p>
        <a href="<?php echo BASE_URL.'/cart.php?add='.$prod['id']; ?>" class="btn">Añadir al carrito</a>
    </div>
    <?php endforeach; ?>
</div>

<?php
require_once 'includes/footer.php';
?>
