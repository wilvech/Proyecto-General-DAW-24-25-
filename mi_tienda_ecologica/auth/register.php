<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) VALUES (:nombre, :email, :password, :direccion, :telefono, 'cliente')");
    $success = $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':password' => $password,
        ':direccion' => $direccion,
        ':telefono' => $telefono
    ]);

    if ($success) {
        $_SESSION['flash_success'] = "Registro exitoso. Ya puedes iniciar sesión.";
        header('Location: login.php');
        exit;
    } else {
        $_SESSION['flash_error'] = "Error al registrar. Intenta con otro correo.";
    }
}
?>

<h1>Registro de Usuario</h1>

<form method="POST">
    <label>Nombre: <input type="text" name="nombre" required></label>
    <label>Email: <input type="email" name="email" required></label>
    <label>Contraseña: <input type="password" name="password" required></label>
    <label>Dirección: <input type="text" name="direccion"></label>
    <label>Teléfono: <input type="text" name="telefono"></label>
    <button type="submit" class="btn">Registrar</button>
</form>

<p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>

<?php require_once '../includes/footer.php'; ?>
