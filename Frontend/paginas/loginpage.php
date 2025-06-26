<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');
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
    <!-- Formulario -->
    <div class="col-md-6">
      <h2>Login</h2>
      <?php if ($mensaje): ?>
        <div class="alert alert-danger"><?= $mensaje ?></div>
      <?php endif; ?>
       <form action=<?php echo '../Backend/login.php'; ?> method="post">
        <input type="email" name="nombreUsuario" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="claveUsuario" class="form-control mb-2" placeholder="Contraseña" required>
        <a href="#" class="small d-block text-end" href="register.php">¿Olvidaste tu contraseña?</a>
        <button class="btn btn-success">Iniciar Sesión</button>
      </form>
    </div>

    <!-- Imagen -->
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="bg-light text-center p-5 border w-100">
        <img src="../assets/imagen/shoppinghall.jpg" class="img-fluid" alt="Imagen de Registro" style="max-width: 100%; height: auto;">
      </div>
    </div>
  </div>
</div>

<?php include '../componentes/pie.php'; ?>