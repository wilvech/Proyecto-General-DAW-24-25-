<?php
require_once '../includes/header.php';
echo "<h1>¡Pago exitoso!</h1>";
echo "<p>Gracias por tu compra. Recibirás un correo con los detalles.</p>";
$_SESSION['cart'] = [];
require_once '../includes/footer.php';
