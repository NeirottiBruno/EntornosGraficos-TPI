<?php
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = trim($_POST['nombre']);
  $email = trim($_POST['email']);
  $pass = $_POST['contrasena'];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mensaje = "Email inválido.";
  } elseif (strlen($pass) < 6) {
    $mensaje = "La contraseña debe tener al menos 6 caracteres.";
  } else {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $hash);
    if ($stmt->execute()) {
      header("Location: login.php");
      exit;
    } else {
      $mensaje = "Error: " . $stmt->error;
    }
  }
}
?>