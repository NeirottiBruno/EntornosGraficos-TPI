<?php
session_start();
include('../../Backend/bd.php');


// SIMULACION sesión de cliente (hasta tener login real)
$_SESSION['usuario'] = 'cliente1@shopping.com';
$_SESSION['tipo_usuario'] = 'cliente';
$_SESSION['cod_usuario'] = 12;


// Verificar login
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header('Location: login.php?error=debes-estar-logueado');
    exit;
}

$codPromo = isset($_GET['id']) ? intval($_GET['id']) : 0;
$codUsuario = $_SESSION['cod_usuario'];

// Obtener info de la promoción
$sqlPromo = "SELECT * FROM promociones WHERE codPromo = $codPromo AND estadoPromo = 'aprobada' AND fechaHastaPromo >= CURDATE()";
$resultPromo = $conexion->query($sqlPromo);

if (!$resultPromo || $resultPromo->num_rows === 0) {
    echo "<p>Promoción no válida o expirada.</p>";
    exit;
}

$promo = $resultPromo->fetch_assoc();

// Obtener categoría del cliente
$sqlUsuario = "SELECT categoriaCliente FROM usuarios WHERE codUsuario = $codUsuario AND tipoUsuario = 'cliente'";
$resultUser = $conexion->query($sqlUsuario);

if (!$resultUser || $resultUser->num_rows === 0) {
    echo "<p>Error al verificar usuario.</p>";
    exit;
}

$categoriaUsuario = $resultUser->fetch_assoc()['categoriaCliente'];
$categoriaPromo = $promo['categoriaCliente'];

$niveles = ['Inicial' => 1, 'Medium' => 2, 'Premium' => 3];
if ($niveles[$categoriaUsuario] < $niveles[$categoriaPromo]) {
    echo "<p>No tenés la categoría necesaria para solicitar esta promoción.</p>";
    exit;
}

// Verificar si ya fue solicitada
$sqlCheck = "SELECT * FROM uso_promociones WHERE codPromo = $codPromo AND codUsuario = $codUsuario";
$resultCheck = $conexion->query($sqlCheck);

if ($resultCheck && $resultCheck->num_rows > 0) {
    $uso = $resultCheck->fetch_assoc();
    echo "<p>Ya solicitaste esta promoción. Tu código es: <strong>{$uso['codigoGenerado']}</strong></p>";
    exit;
}

// Generar código aleatorio
$codigo = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

// Insertar solicitud
$fecha = date('Y-m-d');
$sqlInsert = "INSERT INTO uso_promociones (codPromo, codUsuario, fechaSolicitud, estado, codigoGenerado)
              VALUES ($codPromo, $codUsuario, '$fecha', 'pendiente', '$codigo')";

if ($conexion->query($sqlInsert) === TRUE) {
    echo "<p>Solicitud registrada correctamente. Tu código es: <strong>$codigo</strong></p>";
} else {
    echo "<p>Error al registrar solicitud: " . $conexion->error . "</p>";
}
?>
