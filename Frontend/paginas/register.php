<?php
require 'db.php';
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

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Plaza Shopping</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
include '../componentes/encabezado.php';
?>

  <section class="position-relative" style="height: 420px; overflow: hidden;">
      <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
      <div class="position-absolute top-50 start-50 translate-middle text-white text-center" ; padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
           <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222;">¡Bienvenido a Shopping Plaza!</h1>
      </div>
  </section>



  <!-- Sección Registro -->
  <div class="container mb-5">
    <div class="row">
      <!-- Formulario -->
      <div class="col-md-6">
        <body class="container py-5">
  <h2>Registro</h2>
  <?php if ($mensaje): ?><div class="alert alert-danger"><?= $mensaje ?></div><?php endif; ?>
  <form method="post">
    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre completo" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="password" name="contrasena" class="form-control mb-2" placeholder="Contraseña" required>
    <button class="btn btn-primary">Registrarse</button>
  </form>
</body>
</html>
      </div>

      <!-- Imagen -->
      <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="bg-light text-center p-5 border w-100">
          <h5>IMAGEN</h5>
        </div>
      </div>
    </div>
  </div>

    <?php include '../componentes/pie.php'; ?>
</body>

  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
