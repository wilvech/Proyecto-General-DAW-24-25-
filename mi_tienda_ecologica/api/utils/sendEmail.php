<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php'; // PHPMailer vía Composer

function sendEmail($to, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Cambiar si usas otro proveedor
        $mail->SMTPAuth = true;
        $mail->Username = 'TU_CORREO@gmail.com';
        $mail->Password = 'TU_CONTRASEÑA_O_APP_PASSWORD';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Emisor y destinatario
        $mail->setFrom('TU_CORREO@gmail.com', 'Tienda Ecológica');
        $mail->addAddress($to);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error enviando correo: {$mail->ErrorInfo}");
        return false;
    }
}
