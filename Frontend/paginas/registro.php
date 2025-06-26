<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');

// Mostrar mensaje de error si vuelve del backend
$mensaje = $_GET['error'] ?? '';
?>

<section class="position-relative" style="height: 420px; overflow: hidden;">
    <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
    <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
        <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222;">¡Registrate en Shopping Plaza!</h1>
    </div>
</section>

<!-- Sección Registro -->
<div class="container mb-5 mt-5">
    <div class="row">
        <!-- Formulario -->
        <div class="col-12 col-md-6">
            <h2>Registro</h2>

            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
            <?php endif; ?>
            <br>
            <form action="../../Backend/registro.php" method="POST">
                <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre completo" required>
                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                <input type="password" name="contrasena" class="form-control mb-2" placeholder="Contraseña" required>
                <div class="mb-3" style="display: flex;">
                  <label class="form-label">Tipo de usuario:</label><br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" style="margin-left: 10px; margin-right: 5px;" type="radio" name="tipoUsuario" value="cliente" id="tipoCliente" checked>
                    <label class="form-check-label" for="tipoCliente">Cliente</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" style="margin-left: 10px; margin-right: 5px;" type="radio" name="tipoUsuario" value="dueño de local" id="tipoDueño">
                    <label class="form-check-label" for="tipoDueño">Dueño de Local</label>
                  </div>
                </div>
                <button class="btn btn-primary">Registrarse</button>
            </form>
        </div>

        <!-- Imagen -->
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
            <div class="bg-light text-center border w-100">
                <img src="../assets/imagen/shoppinghall.jpg" class="img-fluid" alt="Imagen de Registro" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<?php include '../componentes/pie.php'; ?>
