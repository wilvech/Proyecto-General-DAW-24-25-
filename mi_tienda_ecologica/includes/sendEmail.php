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
        $mail->Username = '64e957fdd3fdc4';
        $mail->Password = 'f4d70e96741c12';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom($from, 'Tienda Ecológica');
        $mail->addAddress($to);
        $mail->addReplyTo($from);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer Error: {$mail->ErrorInfo}");
        echo "<pre>PHPMailer Error: {$mail->ErrorInfo}</pre>"; //para depurar
        return false;
    }
}
