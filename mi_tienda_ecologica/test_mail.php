<?php
require_once 'includes/sendEmail.php';

if (sendEmail('ecotiendapro@gmail.com', 'Test desde PHP', 'Esto es una prueba enviada desde XAMPP con Mailtrap')) {
    echo "Correo enviado correctamente.";
} else {
    echo "Fallo al enviar correo.";
}
