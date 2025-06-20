<?php
include('../componentes/encabezado.php');
include('../componentes/tarjetaPromocion.php');
include('../../Backend/bd.php');
include_once('../../Backend/funciones.php');

$idLocal = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener info del local
$sqlLocal = "SELECT * FROM locales WHERE codLocal = $idLocal";
$resultLocal = $conexion->query($sqlLocal);
$local = $resultLocal->fetch_assoc();

// Obtener promociones del local
$sqlPromos = "
    SELECT * FROM promociones 
    WHERE codLocal = $idLocal 
    AND estadoPromo = 'aprobada' 
    AND fechaHastaPromo >= CURDATE()";
$resultPromos = $conexion->query($sqlPromos);

// Variables de sesión del cliente -- TEMPORAL ESTO
$usuarioLogueado = isset($_SESSION['usuario']) && $_SESSION['tipo_usuario'] === 'cliente';
$codUsuario = $_SESSION['cod_usuario'] ?? null;
$categoriaUsuario = null;

if ($usuarioLogueado) {
    $sqlCat = "SELECT categoriaCliente FROM usuarios WHERE codUsuario = $codUsuario";
    $resCat = $conexion->query($sqlCat);
    if ($resCat && $resCat->num_rows > 0) {
        $categoriaUsuario = $resCat->fetch_assoc()['categoriaCliente'];
    }
}

// Manejo de solicitud de promoción desde formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solicitar']) && $usuarioLogueado) {
    $codPromoSolicitada = intval($_POST['solicitar']);
    $verifica = $conexion->query("SELECT * FROM uso_promociones WHERE codPromo = $codPromoSolicitada AND codUsuario = $codUsuario");
    if ($verifica && $verifica->num_rows === 0) {
        $codigo = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        $fecha = date('Y-m-d');
        $conexion->query("INSERT INTO uso_promociones (codPromo, codUsuario, fechaSolicitud, estado, codigoGenerado)
                          VALUES ($codPromoSolicitada, $codUsuario, '$fecha', 'pendiente', '$codigo')");
    }
    header("Location: detalleLocal.php?id=$idLocal");
    exit;
}
?>

<!-- BANNER -->
<?php if ($local): ?>
    <div class="bg-light banner-shopping p-4 mb-4 text-center border">
        <h2><?= $local['nombreLocal'] ?></h2>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="locales.php">Locales</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $local['nombreLocal'] ?></li>
        </ol>
    </nav>
    </div>
<?php endif; ?>

<!-- CONTENEDOR -->
<div class="container my-4">
    <?php if ($local): ?>
        <!-- Descripcion -->
        <div class="text-center mb-5">
            <img src="../assets/imagen/<?= $local['logo'] ?>" alt="Logo <?= $local['nombreLocal'] ?>" class="img-fluid mb-3" style="max-height: 80px;">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod tempor incididunt ut labore et dolore magna aliqua.</p>
            <div>
                <i class="fa fa-instagram"></i> &nbsp;
                <i class="fa fa-facebook"></i> &nbsp;
                <i class="fa fa-envelope"></i>
            </div>
        </div>

        <!-- Promociones activas -->
        <h4 class="mb-3">Promociones</h4>
        <div class="row detalleLocal">
            <?php if ($resultPromos && $resultPromos->num_rows > 0): ?>
                <?php while ($promo = $resultPromos->fetch_assoc()): ?>
                    <?php
                    $promo['nombreLocal'] = $local['nombreLocal'];
                    $promo['rubroLocal'] = $local['rubroLocal'];
                    $promo['logo'] = $local['logo'];
                    mostrarTarjetaPromo($promo, $conexion, $usuarioLogueado, $codUsuario, $categoriaUsuario);
                    ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay promociones activas en este momento.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Local no encontrado.</p>
    <?php endif; ?>
</div>

<?php include('../componentes/pie.php'); ?>
