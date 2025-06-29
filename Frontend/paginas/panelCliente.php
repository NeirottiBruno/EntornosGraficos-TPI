<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');

// Verificar si hay sesión activa
if (!isset($_SESSION['cod_usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['cod_usuario'];

// Obtener datos personales del usuario
$sql_usuario = "SELECT nombreUsuario, categoriaCliente FROM usuarios WHERE codUsuario = $usuario_id";
$result_usuario = $conexion->query($sql_usuario);

if (!$result_usuario) {
    die("Error al obtener datos del usuario: " . $conexion->error);
}

$usuario = $result_usuario->fetch_assoc();

// Obtener historial de promociones utilizadas
$sql_cupones = "SELECT p.textoPromo, up.fechaSolicitud, up.estado, up.codigoGenerado FROM uso_promociones up INNER JOIN promociones p ON up.codPromo = p.codPromo WHERE codUsuario = $usuario_id ORDER BY fechaSolicitud DESC";
$result_cupones = $conexion->query($sql_cupones);

if (!$result_cupones) {
    die("Error en la consulta de cupones: " . $conexion->error);
}
?>

<title>Panel Cliente - Rosario Plaza Shopping</title>

<section class="position-relative" style="height: 420px; overflow: hidden;">
    <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
    <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
        <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222; overflow: hidden;">Perfil</h1>
    </div>
</section>

<!-- Datos personales -->
<div class="container mb-4 mt-5">
  <div class="card">
    <div class="card-header bg-primary text-white">
      Datos Personales
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($usuario['nombreUsuario']) ?></li>
      <li class="list-group-item"><strong>Categoría:</strong> <?= htmlspecialchars($usuario['categoriaCliente']) ?></li>
    </ul>
  </div>
</div>

<!-- Historial de promociones que usó el cliente -->
<div class="container mb-5">
  <div class="card">
    <div class="card-header bg-success text-white">
      Historial de Promociones Utilizadas
    </div>
    <ul class="list-group list-group-flush">
      <?php if ($result_cupones->num_rows > 0): ?>
        <?php while ($cupon = $result_cupones->fetch_assoc()): ?>
          <li class="list-group-item">
            <strong>Promo:</strong> <?= htmlspecialchars($cupon['textoPromo']) ?> -
            <em>Usada el <?= date("d/m/Y", strtotime($cupon['fechaSolicitud'])) ?></em><br>
            <strong>Código:</strong> <?= htmlspecialchars($cupon['codigoGenerado']) ?> -
            <em>Estado:</em> <?= htmlspecialchars($cupon['estado']) ?>
          </li>
        <?php endwhile; ?>
      <?php else: ?>
        <li class="list-group-item">No se encontraron promociones usadas.</li>
      <?php endif; ?>
    </ul>
  </div>
</div>


<?php include '../componentes/pie.php'; ?>
