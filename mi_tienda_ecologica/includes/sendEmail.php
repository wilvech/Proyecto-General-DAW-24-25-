<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; // Asegúrate de que Composer esté instalado

function sendEmail($from_email, $from_name, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = MAILTRAP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAILTRAP_USER;
        $mail->Password = MAILTRAP_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port = MAILTRAP_PORT;

        $mail->setFrom($from_email, $from_name);
        $mail->addAddress(MAILTRAP_TO);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error enviando correo: " . $mail->ErrorInfo);
        return false;
    }
}
