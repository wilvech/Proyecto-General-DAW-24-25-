<?php
require_once '../includes/header.php';
require_once '../includes/sendEmail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    if ($email && $nombre && $mensaje) {
        $stmt = $pdo->prepare("INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)");
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':mensaje' => $mensaje
        ]);

        // Notificación al admin
        $contenidoAdmin = "Nuevo mensaje de contacto:<br><br>
                          <strong>Nombre:</strong> $nombre<br>
                          <strong>Email:</strong> $email<br>
                          <strong>Mensaje:</strong><br>$mensaje";
        sendEmail('ecotiendapro@gmail.com', 'Nuevo mensaje de contacto', $contenidoAdmin);

        // Confirmación al usuario
        $contenidoUsuario = "Hola $nombre,<br><br>Gracias por tu mensaje. Te responderemos lo antes posible.<br><br>Saludos,<br><strong>Tienda Ecológica</strong>";
        sendEmail($email, 'Confirmación de contacto - Tienda Ecológica', $contenidoUsuario);

        echo "<p>Mensaje enviado correctamente. Gracias por contactarnos.</p>";
    } else {
        echo "<p style='color:red'>Por favor, completa todos los campos correctamente.</p>";
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
