<?php
require 'db.php';
session_start();
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['email']);
  $pass = $_POST['contrasena'];

  $stmt = $conn->prepare("SELECT id, nombre, contrasena, categoria FROM usuarios WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    if (password_verify($pass, $row['contrasena'])) {
      $_SESSION['usuario_id'] = $row['id'];
      $_SESSION['nombre'] = $row['nombre'];
      $_SESSION['categoria'] = $row['categoria'];
      header("Location: panel.php");
      exit;
    } else {
      $mensaje = "Contraseña incorrecta.";
    }
  } else {
    $mensaje = "Usuario no encontrado.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - Plaza Shopping</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Header Aqui -->

  <section class="position-relative" style="height: 420px; overflow: hidden;">
      <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
      <div class="position-absolute top-50 start-50 translate-middle text-white text-center" ; padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
           <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222;">¡Bienvenido a Shopping Plaza!</h1>
      </div>
  </section>


  <!-- Sección Login -->
  <div class="container mb-5">
    <div class="row">
      <!-- Formulario -->
      <body class="container py-5">
  <h2>Login</h2>
  <?php if ($mensaje): ?><div class="alert alert-danger"><?= $mensaje ?></div><?php endif; ?>
  <form method="post">
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="password" name="contrasena" class="form-control mb-2" placeholder="Contraseña" required>
    <a href="#" class="small d-block text-end">¿Olvidaste tu contraseña?</a>
    <button class="btn btn-success">Iniciar Sesión</button>
  </form>
</body>
</html>

      <!-- Imagen -->
      <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="bg-light text-center p-5 border w-100">
          <h5>IMAGEN</h5>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Aqui -->
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
