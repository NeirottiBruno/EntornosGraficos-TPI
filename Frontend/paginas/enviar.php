<?php

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
use PHPMailer\PHPMailer;
use PHPMailer\Exception;

if (isset($_POST)) {
        $fecha=date("d-m-Y");
        $hora= date("H :i:s");
        $destinatario = 'tallerdeinformatican@yahoo.com';
        $asunto = 'Consulta plazashoppingrosario WEB';
        $mailcli=$_POST['email'];
        $cuerpo = "\n
             Nombre:".$_POST['nombre']."\n".
            "Apellido:". $POST['apellido']."\n".
            "Email:". $_POST['email']."\n".
            "Consulta:". $_POST['texto']."\n".
            " Enviado:". $fecha ."a las". $hora. "\n";

    $mail = new PHPMailer\PHPMailer(true); // Crear una nueva instancia de PHPMailer

    try {
    // Configuración del servidor SMTP
    $mail->SMTPDebug = 2;                                        // Habilitar salida de depuración
    $mail->isSMTP();                                             // Configurar el mailer para usar SMTP
    $mail->Host       = 'smtp.example.com';                      // Especificar servidor SMTP principal y de respaldo
    $mail->SMTPAuth   = true;                                    // Habilitar autenticación SMTP
    $mail->Username   = 'usuario@example.com';                   // Nombre de usuario SMTP
    $mail->Password   = 'password';                              // Contraseña SMTP
    $mail->SMTPSecure = PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;          // Habilitar encriptación TLS; `PHPMailer::ENCRYPTION_SMTPS` también aceptado
    $mail->Port       = 587;                                     // Puerto TCP para conectarse  465 - 587

    // Destinatarios
    $mail->setFrom($mailcli, 'Remitente');
    $mail->addAddress($destinatario, 'Destinatario');     // Añadir un destinatario

    // Contenido del correo
    $mail->isHTML(true);                                  // Configurar formato de correo a HTML
    $mail->Subject = $asunto ;
    $mail->Body    = $cuerpo;

    $mail->send();
    echo 'El correo se ha enviado correctamente';
    } catch (Exception $e) {
    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>