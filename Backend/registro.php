<?php
session_start();
include('bd.php');

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = trim($_POST['nombre']);
  $email = trim($_POST['email']);
  $pass = $_POST['contrasena'];
  $tipoUsuario = $_POST['tipoUsuario'] ?? 'cliente';

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mensaje = "Email inválido.";
  } elseif (strlen($pass) < 6) {
    $mensaje = "La contraseña debe tener al menos 6 caracteres.";
  } else {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $categoriaCliente = ($tipoUsuario === 'cliente') ? 'Inicial' : null;
    $estadoCuenta = ($tipoUsuario === 'cliente') ? 'activo' : 'pendiente';

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente, estadoCuenta) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $hash, $tipoUsuario, $categoriaCliente, $estadoCuenta);

    if ($stmt->execute()) {
      if ($estadoCuenta === 'activo') {
        header("Location: ../Frontend/paginas/login.php?registro=ok");
      } else {
        header("Location: ../Frontend/paginas/login.php?error=" . urlencode("Tu cuenta será revisada por un administrador."));
      }
      exit;
    } else {
      $mensaje = "Error: " . $stmt->error;
    }
  }

  // Si hubo errores redirige de vuelta al formulario con mensaje
  header("Location: ../Frontend/paginas/registro.php?error=" . urlencode($mensaje));
  exit;
}
