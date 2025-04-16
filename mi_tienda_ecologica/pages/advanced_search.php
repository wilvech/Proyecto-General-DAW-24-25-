<?php
require_once '../includes/header.php';

$nombre = $_GET['nombre'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$precio_min = $_GET['precio_min'] ?? '';
$precio_max = $_GET['precio_max'] ?? '';

$query = "SELECT * FROM productos WHERE 1=1";
$params = [];

if ($nombre) {
    $query .= " AND nombre LIKE :nombre";
    $params[':nombre'] = "%$nombre%";
}
if ($categoria) {
    $query .= " AND categoria LIKE :categoria";
    $params[':categoria'] = "%$categoria%";
}
if ($precio_min) {
    $query .= " AND precio >= :precio_min";
    $params[':precio_min'] = $precio_min;
}
if ($precio_max) {
    $query .= " AND precio <= :precio_max";
    $params[':precio_max'] = $precio_max;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Búsqueda Avanzada</h1>
<form method="GET">
    <label>Nombre: <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>"></label>
    <label>Categoría: <input type="text" name="categoria" value="<?= htmlspecialchars($categoria) ?>"></label>
    <label>Precio Mín: <input type="number" name="precio_min" value="<?= htmlspecialchars($precio_min) ?>"></label>
    <label>Precio Máx: <input type="number" name="precio_max" value="<?= htmlspecialchars($precio_max) ?>"></label>
    <button type="submit" class="btn">Buscar</button>
</form>

<div class="product-grid">
    <?php foreach ($results as $prod): ?>
        <div class="product-item">
            <img src="<?= BASE_URL ?>/assets/images/productos/<?= htmlspecialchars($prod['imagen']) ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>" />
            <h3><?= htmlspecialchars($prod['nombre']) ?></h3>
            <p>€<?= htmlspecialchars($prod['precio']) ?></p>
            <a href="<?= BASE_URL ?>/pages/cart.php?add=<?= $prod['id'] ?>" class="btn">Añadir al carrito</a>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../includes/footer.php'; ?>
