<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
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
    $imagenNombre = 'placeholder.png';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $archivoTmp = $_FILES['imagen']['tmp_name'];
        $archivoOriginal = basename($_FILES['imagen']['name']);
        $imagenNombre = time() . "_" . preg_replace('/\s+/', '_', $archivoOriginal);
        $destino = "../assets/images/productos/" . $imagenNombre;

        if (!move_uploaded_file($archivoTmp, $destino)) {
            exit("<p>Error al subir la imagen. Verifica los permisos.</p>");
        }
    }

    $sql = "INSERT INTO productos (nombre, descripcion, precio, categoria, stock, imagen)
            VALUES (:nombre, :descripcion, :precio, :categoria, :stock, :imagen)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre'      => $nombre,
        ':descripcion' => $descripcion,
        ':precio'      => $precio,
        ':categoria'   => $categoria,
        ':stock'       => $stock,
        ':imagen'      => $imagenNombre
    ]);

    header('Location: manage_products.php');
    exit;
}

// Modificar producto
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
        $nombre      = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio      = $_POST['precio'];
        $categoria   = $_POST['categoria'];
        $stock       = $_POST['stock'];

        $stmtOld = $pdo->prepare("SELECT imagen FROM productos WHERE id = :id");
        $stmtOld->execute([':id' => $edit_id]);
        $oldProduct = $stmtOld->fetch(PDO::FETCH_ASSOC);
        $imagenNombre = $oldProduct['imagen'];

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $archivoTmp = $_FILES['imagen']['tmp_name'];
            $archivoOriginal = basename($_FILES['imagen']['name']);
            $imagenNombre = time() . "_" . preg_replace('/\s+/', '_', $archivoOriginal);
            $destino = "../assets/images/productos/" . $imagenNombre;

            if (!move_uploaded_file($archivoTmp, $destino)) {
                exit("<p>Error al subir la imagen nueva.</p>");
            }
        }

        $sqlUpdate = "UPDATE productos SET nombre=:nombre, descripcion=:descripcion, precio=:precio, categoria=:categoria, stock=:stock, imagen=:imagen WHERE id=:id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':nombre'      => $nombre,
            ':descripcion' => $descripcion,
            ':precio'      => $precio,
            ':categoria'   => $categoria,
            ':stock'       => $stock,
            ':imagen'      => $imagenNombre,
            ':id'          => $edit_id
        ]);

        header("Location: manage_products.php");
        exit;
    }

    $stmtEdit = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $stmtEdit->execute([':id' => $edit_id]);
    $productoEdit = $stmtEdit->fetch(PDO::FETCH_ASSOC);
}

// Cargar todos los productos
$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../includes/header.php'; ?>

<main style="padding:20px;">

    <?php if (isset($productoEdit)): ?>
        <h1>Modificar Producto</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" value="<?= htmlspecialchars($productoEdit['nombre']) ?>" required><br><br>
            <textarea name="descripcion" required><?= htmlspecialchars($productoEdit['descripcion']) ?></textarea><br><br>
            <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($productoEdit['precio']) ?>" required><br><br>
            <input type="text" name="categoria" value="<?= htmlspecialchars($productoEdit['categoria']) ?>" required><br><br>
            <input type="number" name="stock" value="<?= htmlspecialchars($productoEdit['stock']) ?>" required><br><br>
            <input type="file" name="imagen"><br><br>
            <button type="submit" name="update_product" class="btn">Actualizar Producto</button>
            <a href="manage_products.php" class="btn">Cancelar</a>
        </form>

    <?php else: ?>
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
                    <td><img src="<?= BASE_URL ?>/assets/images/productos/<?= htmlspecialchars($prod['imagen']) ?>" style="max-width:100px;"></td>
                    <td><?= htmlspecialchars($prod['nombre']) ?></td>
                    <td><?= htmlspecialchars($prod['precio']) ?>€</td>
                    <td><?= htmlspecialchars($prod['categoria']) ?></td>
                    <td><?= htmlspecialchars($prod['stock']) ?></td>
                    <td>
                        <a href="?delete=<?= $prod['id'] ?>" class="btn" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
                        <a href="?edit=<?= $prod['id'] ?>" class="btn">Modificar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Añadir Nuevo Producto</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre" required><br><br>
            <textarea name="descripcion" placeholder="Descripción" required></textarea><br><br>
            <input type="number" step="0.01" name="precio" placeholder="Precio" required><br><br>
            <input type="text" name="categoria" placeholder="Categoría" required><br><br>
            <input type="number" name="stock" placeholder="Stock" required><br><br>
            <input type="file" name="imagen" required><br><br>
            <button type="submit" name="add_product" class="btn">Añadir Producto</button>
        </form>
    <?php endif; ?>

</main>

<?php require_once '../includes/footer.php'; ?>
