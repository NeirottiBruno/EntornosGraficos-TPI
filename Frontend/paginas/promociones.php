<?php
include('../componentes/encabezado.php');
include('../componentes/tarjetaPromocion.php');
include('../../Backend/bd.php');

// Variables para filtros
$rubro = $_GET['rubro'] ?? '';
$diasSeleccionados = $_GET['dias'] ?? [];

// SQL
$sql = "SELECT promociones.*, locales.nombreLocal, locales.rubroLocal, locales.logo FROM promociones INNER JOIN locales ON promociones.codLocal = locales.codLocal WHERE CURDATE() <= promociones.fechaHastaPromo AND promociones.estadoPromo = 'aprobada'";

// Filtro por rubro
if (!empty($rubro)) {
    $sql .= " AND locales.rubroLocal = '" . $conexion->real_escape_string($rubro) . "'";
}

// Filtro por días
if (!empty($diasSeleccionados)) {
    $condicionesDias = [];
    foreach ($diasSeleccionados as $dia) {
        $condicionesDias[] = "promociones.diasSemana LIKE '%" . $conexion->real_escape_string($dia) . "%'";
    }
    $sql .= " AND (" . implode(" OR ", $condicionesDias) . ")";
}

$resultado = $conexion->query($sql);

// Datos de sesión
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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solicitar']) && $usuarioLogueado) {
    $codPromoSolicitada = intval($_POST['solicitar']);
    // Verificar si ya la solicitó
    $verifica = $conexion->query("SELECT * FROM uso_promociones WHERE codPromo = $codPromoSolicitada AND codUsuario = $codUsuario");
    if ($verifica && $verifica->num_rows === 0) {
        $codigo = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        $fecha = date('Y-m-d');
        $conexion->query("INSERT INTO uso_promociones (codPromo, codUsuario, fechaSolicitud, estado, codigoGenerado)
                          VALUES ($codPromoSolicitada, $codUsuario, '$fecha', 'pendiente', '$codigo')");
    }
    // Redirigir (para evitar repost al refrescar)
    header("Location: promociones.php");
    exit;
}
?>

<title>Promociones - Rosario Plaza Shopping</title>

<div class="container my-4">
    <?php if ($codUsuario == null): ?>
        <div class="alert alert-info" style="margin-bottom: 2rem !important;">Inicia sesión como cliente para solicitar una promoción.</div>
    <?php endif; ?>

    <div class="row">

        <!-- Filtros -->
        <aside class="col-12 col-md-3 mb-4">
            <div class="filtros-promos p-3 border rounded bg-white">
                <h5>Filtros</h5>
                <form method="GET">
                    <div class="mb-2">
                        <label for="rubro">Filtrar por Rubro:</label>
                        <select name="rubro" id="rubro" class="form-select">
                            <option value="">-- Todos --</option>
                            <?php
                            $rubros = ["Indumentaria", "Accesorios", "Comida", "Tecnología"];
                            foreach ($rubros as $r):
                                $selected = ($rubro === $r) ? 'selected' : '';
                                echo "<option value=\"$r\" $selected>$r</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <p class="mt-2 mb-1">Filtrar por día:</p>
                    <?php
                    $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                    foreach ($dias as $dia):
                        $checked = in_array($dia, $diasSeleccionados) ? 'checked' : '';
                    ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="dias[]" value="<?= $dia ?>" id="<?= $dia ?>" <?= $checked ?>>
                            <label class="form-check-label" for="<?= $dia ?>"><?= $dia ?></label>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-dark btn-sm mt-3 w-100">Filtrar</button>
                    <?php if (!empty($rubro) || !empty($diasSeleccionados)): ?>
                        <a href="promociones.php" class="btn btn-outline-secondary btn-sm mt-2 w-100">Borrar filtros</a>
                    <?php endif; ?>
                </form>
            </div>
        </aside>

        <!-- Promociones -->
        <section class="col-12 col-md-9">
            <div class="row">
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($promo = $resultado->fetch_assoc()): ?>
                        <?php mostrarTarjetaPromo($promo, $conexion, $usuarioLogueado, $codUsuario, $categoriaUsuario); ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No hay promociones disponibles.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php include('../componentes/pie.php'); ?>