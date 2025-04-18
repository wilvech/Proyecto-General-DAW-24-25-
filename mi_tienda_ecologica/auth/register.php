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
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <?php include '../includes/campo_password.php'; ?>

    <label>Dirección:</label>
    <input type="text" name="direccion">

    <label>Teléfono:</label>
    <input type="text" name="telefono">

    <button type="submit" class="btn">Registrar</button>
</form>

<p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>

<!-- JavaScript para mostrar/ocultar contraseña -->
<script>
function mostrarPassword() {
    const input = document.getElementById("password");
    const icono = document.getElementById("icono-ojo");
    input.type = "text";
    icono.src = "<?php echo BASE_URL; ?>/assets/images/eye-open.png";
}

function ocultarPassword() {
    const input = document.getElementById("password");
    const icono = document.getElementById("icono-ojo");
    input.type = "password";
    icono.src = "<?php echo BASE_URL; ?>/assets/images/eye-closed.png";
}
</script>

<?php require_once '../includes/footer.php'; ?>
