<?php
session_start();
include('bd.php');

if (!isset($conexion)) {
    die("No se pudo establecer la conexión a la base de datos.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['emailUsuario']);
  $pass = $_POST['claveUsuario'];

  $stmt = $conexion->prepare("SELECT codUsuario, nombreUsuario, emailUsuario, claveUsuario, tipoUsuario, categoriaCliente, estadoCuenta FROM usuarios WHERE emailUsuario = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    // Verifica si el usuario está aprobado
    if ($row['estadoCuenta'] !== 'activo') {
      header("Location: ../Frontend/paginas/login.php?error=" . urlencode("Tu cuenta aún no ha sido aprobada."));
      exit;
    }

    // Validar contraseña (idealmente despues podemos usar password_verify)
    if ($pass == $row['claveUsuario']) {
      $_SESSION['cod_usuario'] = $row['codUsuario'];
      $_SESSION['usuario'] = $row['nombreUsuario'];
      $_SESSION['email_usuario'] = $row['emailUsuario'];
      $_SESSION['tipo_usuario'] = $row['tipoUsuario'];
      $_SESSION['categoriaCliente'] = $row['categoriaCliente'];

      if ($row['tipoUsuario'] === 'cliente') {
        header("Location: ../Frontend/paginas/panelCliente.php");
      } else if ($row['tipoUsuario'] === 'dueño de local') {
        header("Location: ../Frontend/paginas/panelDueño.php");
      } else if ($row['tipoUsuario'] === 'administrador') {
        header("Location: ../Frontend/paginas/panelAdministrador.php");
      } else {
        header("Location: ../Frontend/paginas/login.php?error=" . urlencode("Tipo de usuario no válido."));
      }
      exit;
    } else {
      header("Location: ../Frontend/paginas/login.php?error=" . urlencode("Contraseña incorrecta."));
      exit;
    }
  } else {
    header("Location: ../Frontend/paginas/login.php?error=" . urlencode("Usuario no encontrado."));
    exit;
  }
}
?>
