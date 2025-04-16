<?php
session_start();
require_once '../includes/header.php';
require_once '../includes/auth.php';

if ($_SESSION['usuario_rol'] !== 'admin') exit("<p>No tienes permisos para acceder.</p>");

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['delete']]);
    header("Location: manage_products.php");
    exit;
}

// Añadir producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $imagen = 'placeholder.png';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imgName = time() . '_' . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../assets/images/productos/$imgName");
        $imagen = $imgName;
    }

    $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, categoria, stock, imagen)
        VALUES (:nombre, :descripcion, :precio, :categoria, :stock, :imagen)");
    $stmt->execute([
        ':nombre' => $_POST['nombre'],
        ':descripcion' => $_POST['descripcion'],
        ':precio' => $_POST['precio'],
        ':categoria' => $_POST['categoria'],
        ':stock' => $_POST['stock'],
        ':imagen' => $imagen
    ]);
    header("Location: manage_products.php");
    exit;
}

$productos = $pdo->query("SELECT * FROM productos")->fetchAll(PDO::FETCH_ASSOC);
?>

<main style="padding:20px;">
    <h1>Gestionar Productos</h1>
    <table>
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
                <td><?= $prod['id'] ?></td>
                <td><img src="<?= BASE_URL ?>/assets/images/productos/<?= $prod['imagen'] ?>" width="60"></td>
                <td><?= htmlspecialchars($prod['nombre']) ?></td>
                <td>€<?= $prod['precio'] ?></td>
                <td><?= htmlspecialchars($prod['categoria']) ?></td>
                <td><?= $prod['stock'] ?></td>
                <td><a href="?delete=<?= $prod['id'] ?>" class="btn">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Añadir Producto</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <textarea name="descripcion" placeholder="Descripción" required></textarea><br>
        <input type="number" name="precio" step="0.01" placeholder="Precio" required><br>
        <input type="text" name="categoria" placeholder="Categoría" required><br>
        <input type="number" name="stock" placeholder="Stock" required><br>
        <input type="file" name="imagen"><br>
        <button type="submit" name="add_product" class="btn">Añadir</button>
    </form>
</main>

<?php require_once '../includes/footer.php'; ?>
