<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';
include('bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Buscar usuario con ese email
    $stmt = $conexion->prepare("SELECT codUsuario, nombreUsuario FROM usuarios WHERE emailUsuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $usuario = $res->fetch_assoc();

        // Generar nueva contraseña
        $nuevaPass = substr(str_shuffle("abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789"), 0, 8);

        // Guardar nueva contraseña (plana o hash si usás password_verify)
        $update = $conexion->prepare("UPDATE usuarios SET claveUsuario = ? WHERE codUsuario = ?");
        $update->bind_param("si", $nuevaPass, $usuario['codUsuario']);
        $update->execute();

        // Enviar email con PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'bneirotti@gmail.com';
            $mail->Password   = 'hdgl loyw piat ogln'; // contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('bneirotti@gmail.com', 'Rosario Plaza Shopping');
            $mail->addAddress($email, $usuario['nombreUsuario']);

            $mail->isHTML(true);
            $mail->Subject = 'Tu nueva clave - Rosario Plaza Shopping';
            $mail->Body    = "
                <h4>Hola {$usuario['nombreUsuario']},</h4>
                <p>Tu nueva contraseña es: <strong>$nuevaPass</strong></p>
            ";

            $mail->send();
            echo "<script>alert('Te enviamos una nueva contraseña al correo.'); window.location.href='../Frontend/paginas/login.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error al enviar el email: {$mail->ErrorInfo}'); history.back();</script>";
        }

    } else {
        echo "<script>alert('No se encontró ningún usuario con ese correo.'); history.back();</script>";
    }
}
?>
