<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');
?>

<section class="position-relative" style="height: 420px; overflow: hidden;">
    <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
    <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
          <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222;">Ingrese a su Cuenta</h1>
    </div>
</section>

<!-- Sección Login -->
<div class="container mb-5 mt-5">
  <div class="row">
    <!-- Formulario -->
    <div class="col-md-6" style="display: flex; flex-direction: column; justify-content: center;">
      <h2>Iniciar Sesión</h2>
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
      <?php endif; ?>
      <br>
      <form action="../../Backend/login.php" method="POST">
        <input type="email" name="nombreUsuario" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="claveUsuario" class="form-control" placeholder="Contraseña" required>
        <div class="mt-4" style="display: flex; justify-content: space-between;">
          <button class="btn btn-success">Iniciar Sesión</button>
          <a class="small d-block text-end" href="registro.php">¿Aún no tenés una cuenta?</a>
        </div>
      </form>
    </div>

    <!-- Imagen -->
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="bg-light text-center border w-100 mt-4">
        <img src="../assets/imagen/shoppinghall.jpg" class="img-fluid" alt="Imagen de Registro" style="max-width: 100%; height: auto;">
      </div>
    </div>
  </div>
</div>

<?php include '../componentes/pie.php'; ?>