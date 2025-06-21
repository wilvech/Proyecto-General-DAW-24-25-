<?php
require_once '../includes/header.php';

$nombre = $_GET['nombre'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$precio_min = $_GET['precio_min'] ?? '';
$precio_max = $_GET['precio_max'] ?? '';

$query = "SELECT * FROM productos WHERE 1=1";
if ($nombre)     $query .= " AND nombre LIKE '%$nombre%'";
if ($categoria)  $query .= " AND categoria LIKE '%$categoria%'";
if ($precio_min) $query .= " AND precio >= $precio_min";
if ($precio_max) $query .= " AND precio <= $precio_max";

$stmt = $pdo->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Búsqueda Avanzada</h1>

<form method="GET">
    <label>Nombre: <input type="text" name="nombre" value="<?= $nombre ?>"></label>
    <label>Categoría: <input type="text" name="categoria" value="<?= $categoria ?>"></label>
    <label>Precio Mín: <input type="number" step="0.01" name="precio_min" value="<?= $precio_min ?>"></label>
    <label>Precio Máx: <input type="number" step="0.01" name="precio_max" value="<?= $precio_max ?>"></label>
    <button type="submit">Buscar</button>
</form>

<div class="product-grid">
    <?php foreach ($results as $prod): ?>
        <div class="product-item">
            <img src="<?= htmlspecialchars($prod['imagen']) ?>" alt="<?= $prod['nombre'] ?>" />
            <h3><?= $prod['nombre'] ?></h3>
            <p>€<?= $prod['precio'] ?></p>
            <a href="cart.php?add=<?= $prod['id'] ?>" class="btn">Añadir al carrito</a>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../includes/footer.php'; ?>
