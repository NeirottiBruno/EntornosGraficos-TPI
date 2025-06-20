<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "plazadb");
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// ID del usuario logueado (por ejemplo, desde sesión)
$usuario_id = 1;

// Obtener datos personales
$sql_usuario = "SELECT nombre, email, categoria FROM usuarios WHERE id = $usuario_id";
$result_usuario = $conexion->query($sql_usuario);
$usuario = $result_usuario->fetch_assoc();

// Obtener historial de promociones
$sql_cupones = "SELECT descripcion, fecha FROM cupones_usados WHERE usuario_id = $usuario_id ORDER BY fecha DESC";
$result_cupones = $conexion->query($sql_cupones);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Cliente</title>
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



<!-- Datos personales -->
<div class="container mb-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      Datos Personales
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></li>
      <li class="list-group-item"><strong>Categoría:</strong> <?= htmlspecialchars($usuario['categoria']) ?></li>
      <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></li>
    </ul>
  </div>
</div>

<!-- Historial de promociones -->
<div class="container mb-5">
  <div class="card">
    <div class="card-header bg-success text-white">
      Historial de Promociones Utilizadas
    </div>
    <ul class="list-group list-group-flush">
      <?php while ($cupon = $result_cupones->fetch_assoc()): ?>
        <li class="list-group-item">
          <strong>Promo:</strong> <?= htmlspecialchars($cupon['descripcion']) ?> -
          <em>Usada el <?= date("d/m/Y", strtotime($cupon['fecha'])) ?></em>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</div>

<!-- Footer Aqui -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
