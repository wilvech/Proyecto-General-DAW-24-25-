<?php
require_once '../includes/header.php';
require_once '../components/flash_message.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    if ($email !== 'ecotiendapro@gmail.com') {
        $_SESSION['flash_error'] = "Solo los trabajadores autorizados pueden registrarse como administrador.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) VALUES (:nombre, :email, :password, :direccion, :telefono, 'admin')");
        $success = $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':password' => $password,
            ':direccion' => $direccion,
            ':telefono' => $telefono
        ]);

        if ($success) {
            $_SESSION['flash_success'] = "Registro exitoso como administrador.";
            header('Location: login.php');
            exit;
        } else {
            $_SESSION['flash_error'] = "Error al registrar el administrador.";
        }
    }
}
?>

<h1>Registro de Trabajadores</h1>

<form method="POST">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label for="password">Contraseña:</label>
    <div class="password-container">
        <input type="password" name="password" id="password" required>
        <img id="icono-ojo" class="toggle-password-img"
             src="<?php echo BASE_URL; ?>/assets/images/eye-closed.png"
             alt="Mostrar contraseña"
             onmousedown="mostrarPassword()" 
             onmouseup="ocultarPassword()" 
             onmouseleave="ocultarPassword()">
    </div>

    <label>Dirección:</label>
    <input type="text" name="direccion">

    <label>Teléfono:</label>
    <input type="text" name="telefono">

    <button type="submit" class="btn">Registrar Administrador</button>
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
