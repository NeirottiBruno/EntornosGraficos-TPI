<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';

$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';

if (empty($nombre) || empty($email) || empty($mensaje)) {
    die("Faltan datos obligatorios.");
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'bneirotti@gmail.com';
    $mail->Password   = 'hdgl loyw piat ogln';  // contraseña de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('bneirotti@gmail.com', 'Formulario Rosario Plaza Shopping');
    $mail->addAddress('bneirotti@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje desde el formulario de contacto';
    $mail->Body    = "
        <h3>Mensaje recibido desde la web</h3>
        <p><strong>Nombre:</strong> $nombre</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Mensaje:</strong><br>$mensaje</p>
    ";

    $mail->send();
    echo "<script>alert('Mensaje enviado con éxito.'); window.location.href='../Frontend/paginas/contacto.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Error al enviar el mensaje: {$mail->ErrorInfo}'); window.location.href='../Frontend/paginas/contacto.php';</script>";
}
