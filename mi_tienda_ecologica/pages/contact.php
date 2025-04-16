<?php
require_once '../includes/header.php';

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

    echo "<p>Gracias por tu mensaje. Te responderemos pronto.</p>";
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