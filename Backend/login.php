<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');

if (!isset($conexion)) {
    die("No se pudo establecer la conexión a la base de datos.");
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['nombreUsuario']);
  $pass = $_POST['claveUsuario'];

  $stmt = $conexion->prepare("SELECT codUsuario, nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente FROM usuarios WHERE nombreUsuario = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    if ($pass == $row['claveUsuario']) {  // Si tuvieramos la contraseña encriptada podemos usar password_verify()
      $_SESSION['cod_usuario'] = $row['codUsuario'];
      $_SESSION['usuario'] = $row['nombreUsuario'];
      $_SESSION['tipo_usuario'] = $row['tipoUsuario'];
      $_SESSION['categoriaCliente'] = $row['categoriaCliente'];
      header("Location: panelCliente.php");
      exit;
    } else {
      $mensaje = "Contraseña incorrecta.";
    }
  } else {
    $mensaje = "Usuario no encontrado.";
  }
}
?>