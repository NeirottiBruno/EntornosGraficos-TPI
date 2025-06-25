<?php
session_start();
include('bd.php');
header('Content-Type: application/json');

// Verificar que sea dueño
$tipoUsuario = trim(strtolower($_SESSION['tipo_usuario'] ?? '')); // normalizar por caracter especial ñ
if (!isset($_SESSION['usuario']) || $tipoUsuario !== 'dueño de local') {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$codUsuario = $_SESSION['cod_usuario'];

// Obtener el local asociado
$resLocal = $conexion->query("SELECT codLocal, logo FROM locales WHERE codUsuario = $codUsuario");
if (!$resLocal || $resLocal->num_rows === 0) {
    echo json_encode(['ok' => false, 'error' => 'Local no encontrado']);
    exit;
}
$local = $resLocal->fetch_assoc();
$codLocal = $local['codLocal'];
$logo = $local['logo'];

// Tomar datos del POST
$textoPromo = $conexion->real_escape_string($_POST['textoPromo'] ?? '');
$categoria = $conexion->real_escape_string($_POST['categoriaCliente'] ?? '');
$fechaHasta = $conexion->real_escape_string($_POST['fechaHastaPromo'] ?? '');
$diasSemana = $conexion->real_escape_string($_POST['diasSemana'] ?? '');

if (empty($textoPromo) || empty($categoria) || empty($fechaHasta) || empty($diasSemana)) {
    echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
    exit;
}

// Insertar la promoción
$fechaDesde = date("Y-m-d");
$sql = "INSERT INTO promociones (textoPromo, categoriaCliente, fechaDesdePromo, fechaHastaPromo, diasSemana, estadoPromo, codLocal)
        VALUES ('$textoPromo', '$categoria', '$fechaDesde' , '$fechaHasta', '$diasSemana', 'pendiente', $codLocal)";
$ok = $conexion->query($sql);
if (!$ok) {
    echo json_encode(['ok' => false, 'error' => 'Error en la BD']);
    exit;
}

$codPromo = $conexion->insert_id;

// Generar HTML para insertar la tarjeta nueva
ob_start();
?>
<div class="col-12 col-sm-6 col-lg-4 mb-3" id="promo_<?= $codPromo ?>">
    <div class="border rounded p-2 h-100">
        <p><strong><?= $textoPromo ?></strong></p>
        <span class="badge bg-warning">Pendiente</span>
        <button class="btn btn-sm btn-outline-danger w-100 mt-2 btn-eliminar" data-id="<?= $codPromo ?>">Eliminar</button>
    </div>
</div>
<?php
$html = ob_get_clean();

echo json_encode(['ok' => true, 'html' => $html]);