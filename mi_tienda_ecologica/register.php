<?php
require_once 'includes/header.php';

// Procesar el formulario de registro
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre    = $_POST['nombre'];
    $email     = $_POST['email'];
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $telefono  = $_POST['telefono'];

    // Insertar en la base de datos
    $sql = "INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) 
            VALUES (:nombre, :email, :password, :direccion, :telefono, 'cliente')";
    $stmt = $pdo->prepare($sql);

    if($stmt->execute([
        ':nombre'    => $nombre,
        ':email'     => $email,
        ':password'  => $password,
        ':direccion' => $direccion,
        ':telefono'  => $telefono
    ])){
        echo "<p>Usuario registrado con éxito. <a href='login.php'>Inicia sesión</a></p>";
    } else {
        echo "<p>Error al registrar usuario.</p>";
    }
}
?>

<h1>Registro de Usuario</h1>
<form method="POST" action="">
    <label>Nombre: <input type="text" name="nombre" required></label>
    <label>Email: <input type="email" name="email" required></label>
    <label>Contraseña: <input type="password" name="password" required></label>
    <label>Dirección: <input type="text" name="direccion"></label>
    <label>Teléfono: <input type="text" name="telefono"></label>
    
    <!-- Contenedor para los botones alineados horizontalmente -->
    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <!-- Botón de Registro (submit) -->
        <button type="submit" class="btn">Registrar</button>
        <!-- Enlace a login con la misma clase y estilo -->
        <a href="<?php echo BASE_URL; ?>/login.php" class="btn">Loguéate</a>
    </div>
</form>

<?php
require_once 'includes/footer.php';
?>
