<?php
require_once '../includes/header.php';
require_once '../includes/sendEmail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    $stmt = $pdo->prepare("INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)");
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':mensaje' => $mensaje
    ]);

    // Enviar notificación a administrador
    $contenido = "Nuevo mensaje de contacto:<br><br>Nombre: $nombre<br>Email: $email<br>Mensaje:<br>$mensaje";
    $enviado = sendEmail('ecotiendapro@gmail.com', 'Nuevo mensaje de contacto', $contenido);

    if ($enviado) {
        echo "<p>Mensaje enviado correctamente. Gracias por contactarnos.</p>";
    } else {
        echo "<p>Error al enviar el mensaje. Inténtalo más tarde.</p>";
    }
}
?>

<h1>Contacto</h1>
<form method="POST">
    <label>Nombre: <input type="text" name="nombre" required></label><br><br>
    <label>Email: <input type="email" name="email" required></label><br><br>
    <label>Mensaje: <textarea name="mensaje" required></textarea></label><br><br>
    <button type="submit" class="btn">Enviar</button>
</form>

<?php require_once '../includes/footer.php'; ?>
