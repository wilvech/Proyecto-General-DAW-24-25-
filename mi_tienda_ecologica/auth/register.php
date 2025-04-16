<?php
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) VALUES (:nombre, :email, :password, :direccion, :telefono, 'cliente')");
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':password' => $hash,
        ':direccion' => $direccion,
        ':telefono' => $telefono
    ]);

    echo "<p>Registro exitoso. <a href='login.php'>Inicia sesión</a>.</p>";
}
?>

<h1>Registro de Usuario</h1>
<form method="POST">
    <label>Nombre: <input type="text" name="nombre" required></label><br><br>
    <label>Email: <input type="email" name="email" required></label><br><br>
    <label>Contraseña: <input type="password" name="password" required></label><br><br>
    <label>Dirección: <input type="text" name="direccion"></label><br><br>
    <label>Teléfono: <input type="text" name="telefono"></label><br><br>
    <button type="submit" class="btn">Registrar</button>
</form>
<p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>

<?php require_once '../includes/footer.php'; ?>
