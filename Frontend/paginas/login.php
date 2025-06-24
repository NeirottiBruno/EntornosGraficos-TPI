<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');

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

<section class="position-relative" style="height: 420px; overflow: hidden;">
    <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
    <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
          <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222;">¡Bienvenido a Shopping Plaza!</h1>
    </div>
</section>

<!-- Sección Login -->
<div class="container mb-5">
  <div class="row">
    <div class="col-md-6">
      <h2>Login</h2>
      <?php if ($mensaje): ?><div class="alert alert-danger"><?= $mensaje ?></div><?php endif; ?>
      <form method="post">
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="contrasena" class="form-control mb-2" placeholder="Contraseña" required>
        <a href="#" class="small d-block text-end">¿Olvidaste tu contraseña?</a>
        <button class="btn btn-success">Iniciar Sesión</button>
      </form>
    </div>

    <!-- Imagen -->
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="bg-light text-center p-5 border w-100">
        <img src="../assets/imagen/shoppinghall.jpg" class="img-fluid" alt="Imagen de Login" style="max-width: 100%; height: auto;">
      </div>
    </div>
  </div>
</div>

<?php include '../componentes/pie.php'; ?>

