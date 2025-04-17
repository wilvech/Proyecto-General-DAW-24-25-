<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/config.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') {
    exit("<p>No tienes permisos para acceder a esta sección.</p>");
}

// Eliminar producto
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['delete']]);
    header("Location: manage_products.php");
    exit;
}

// Añadir nuevo producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $nombre      = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio      = $_POST['precio'];
    $categoria   = $_POST['categoria'];
    $stock       = $_POST['stock'];
    $imagenURL   = $_POST['imagen_url'];

    $sql = "INSERT INTO productos (nombre, descripcion, precio, categoria, stock, imagen)
            VALUES (:nombre, :descripcion, :precio, :categoria, :stock, :imagen)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre'      => $nombre,
        ':descripcion' => $descripcion,
        ':precio'      => $precio,
        ':categoria'   => $categoria,
        ':stock'       => $stock,
        ':imagen'      => $imagenURL
    ]);

    header('Location: manage_products.php');
    exit;
}

// Cargar todos los productos
$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../includes/header.php'; ?>

<main style="padding:20px;">
    <h1>Gestionar Productos</h1>

    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; margin-bottom:20px;">
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Categoría</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $prod): ?>
            <tr>
                <td><?= htmlspecialchars($prod['id']) ?></td>
                <td><img src="<?= htmlspecialchars($prod['imagen']) ?>" style="max-width:100px;"></td>
                <td><?= htmlspecialchars($prod['nombre']) ?></td>
                <td><?= htmlspecialchars($prod['precio']) ?>€</td>
                <td><?= htmlspecialchars($prod['categoria']) ?></td>
                <td><?= htmlspecialchars($prod['stock']) ?></td>
                <td>
                    <a href="?delete=<?= $prod['id'] ?>" class="btn" onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Añadir Nuevo Producto</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre del producto" required><br><br>
        <textarea name="descripcion" placeholder="Descripción detallada" required></textarea><br><br>
        <input type="number" step="0.01" name="precio" placeholder="Precio (€)" required><br><br>
        <input type="text" name="categoria" placeholder="Categoría" required><br><br>
        <input type="number" name="stock" placeholder="Stock disponible" required><br><br>
        <input type="url" name="imagen_url" placeholder="URL de la imagen (ej. https://...)" required><br><br>
        <button type="submit" name="add_product" class="btn">Añadir Producto</button>
    </form>
</main>

<?php require_once '../includes/footer.php'; ?>
