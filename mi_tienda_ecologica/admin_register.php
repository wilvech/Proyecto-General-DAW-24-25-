<?php
require_once 'includes/header.php';

// Procesar el formulario de registro de administrador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = $_POST['nombre'];
    $email     = $_POST['email'];
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $telefono  = $_POST['telefono'];

    // Insertar en la base de datos asignando el rol 'admin'
    $sql = "INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) 
            VALUES (:nombre, :email, :password, :direccion, :telefono, 'admin')";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([
        ':nombre'    => $nombre,
        ':email'     => $email,
        ':password'  => $password,
        ':direccion' => $direccion,
        ':telefono'  => $telefono
    ])) {
        // Opcionalmente, podrías iniciar sesión automáticamente o redirigir al login
        echo "<p>Administrador registrado exitosamente. <a href='login.php'>Inicia sesión</a></p>";
    } else {
        echo "<p>Error al registrar administrador.</p>";
    }
}
?>

<h1>Registro de Administrador</h1>
<form method="POST" action="">
    <label>Nombre: <input type="text" name="nombre" required /></label>
    <label>Email: <input type="email" name="email" required /></label>
    <label>Contraseña: <input type="password" name="password" required /></label>
    <label>Dirección: <input type="text" name="direccion" /></label>
    <label>Teléfono: <input type="text" name="telefono" /></label>
    <button type="submit" class="btn">Registrar Administrador</button>
</form>

<?php
require_once 'includes/footer.php';
?>
