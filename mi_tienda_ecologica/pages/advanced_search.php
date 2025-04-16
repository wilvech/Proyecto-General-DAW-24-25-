<?php
require_once __DIR__ . '/../includes/header.php';

// Recoger parámetros de búsqueda
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : '';
$precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : '';

// Construir consulta de forma dinámica
$query = "SELECT * FROM productos WHERE 1=1";
if (!empty($nombre)) {
    $query .= " AND nombre LIKE '%$nombre%'";
}
if (!empty($categoria)) {
    $query .= " AND categoria LIKE '%$categoria%'";
}
if (!empty($precio_min)) {
    $query .= " AND precio >= $precio_min";
}
if (!empty($precio_max)) {
    $query .= " AND precio <= $precio_max";
}

$stmt = $pdo->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Búsqueda Avanzada</h1>
<form method="GET" action="">
    <label>Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>"></label>
    <label>Categoría: <input type="text" name="categoria" value="<?php echo $categoria; ?>"></label>
    <label>Precio Mín: <input type="number" step="0.01" name="precio_min" value="<?php echo $precio_min; ?>"></label>
    <label>Precio Máx: <input type="number" step="0.01" name="precio_max" value="<?php echo $precio_max; ?>"></label>
    <button type="submit">Buscar</button>
</form>

<div class="product-grid">
    <?php foreach ($results as $prod): ?>
        <div class="product-item">
            <img src="<?php echo BASE_URL . '/assets/images/productos/' . $prod['imagen']; ?>" alt="<?php echo $prod['nombre']; ?>" />
            <h3><?php echo $prod['nombre']; ?></h3>
            <p>€<?php echo $prod['precio']; ?></p>
            <a href="<?php echo BASE_URL . '/pages/cart.php?add=' . $prod['id']; ?>" class="btn">Añadir al carrito</a>
        </div>
    <?php endforeach; ?>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>