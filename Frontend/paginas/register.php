<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');

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


<section class="position-relative" style="height: 420px; overflow: hidden;">
    <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
    <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
          <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222;">¡Bienvenido a Shopping Plaza!</h1>
    </div>
</section>


<!-- Sección Registro -->
<div class="container mb-5">
  <div class="row align-items-center" style="min-height: 80vh;">
    <!-- Formulario -->
    <div class="col-12 col-md-6">
      <h2>Registro</h2>
      <?php if ($mensaje): ?><div class="alert alert-danger"><?= $mensaje ?></div><?php endif; ?>
      <form method="post">
        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre completo" required>
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="contrasena" class="form-control mb-2" placeholder="Contraseña" required>
        <button class="btn btn-primary">Registrarse</button>
      </form>
    </div>

    <!-- Imagen -->
    <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
      <div class="bg-light text-center p-5 border w-100">
        <img src="../assets/imagen/shoppinghall.jpg" class="img-fluid" alt="Imagen de Registro" style="max-width: 100%; height: auto;">
      </div>
    </div>
  </div>
</div>


<?php include '../componentes/pie.php'; ?>

