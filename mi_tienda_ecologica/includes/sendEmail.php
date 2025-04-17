<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendEmail($to, $subject, $message, $from = 'noreply@tiendaecologica.com') {
    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP para Mailtrap
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '64e957fdd3fdc4'; // tu usuario Mailtrap
        $mail->Password = '1c12';           // tu contraseña Mailtrap
        $mail->Port = 587;

        $mail->setFrom($from, 'Tienda Ecológica');
        $mail->addAddress($to);

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
