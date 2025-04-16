<?php
require_once 'includes/header.php';
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Insertar en la base de datos
    $sql = "INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)";
    $stmt = $pdo->prepare($sql);
    $resultado = $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':mensaje' => $mensaje
    ]);

    if ($resultado) {
        echo "<p>Gracias por tu mensaje, $nombre. Nos pondremos en contacto pronto.</p>";
    } else {
        echo "<p>Hubo un error al enviar tu mensaje, inténtalo más tarde.</p>";
    }
}
?>

<h1>Contacto</h1>
<form method="POST" action="">
    <label>Nombre: <input type="text" name="nombre" required></label><br><br>
    <label>Email: <input type="email" name="email" required></label><br><br>
    <label>Mensaje: <textarea name="mensaje" required></textarea></label><br><br>
    <button type="submit" class="btn">Enviar</button>
</form>

<?php require_once 'includes/footer.php'; ?>
