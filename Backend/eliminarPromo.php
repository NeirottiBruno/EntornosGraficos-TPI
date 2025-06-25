<?php
session_start();
include('bd.php');
header('Content-Type: application/json');

// Verificar sesión y tipo
$tipoUsuario = trim(strtolower($_SESSION['tipo_usuario'] ?? '')); // normalizar por caracter especial ñ
if (!isset($_SESSION['usuario']) || $tipoUsuario !== 'dueño de local') {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$codUsuario = $_SESSION['cod_usuario'] ?? 0;
$codPromo = intval($_POST['codPromo'] ?? 0);

// Confirmar que la promoción sea del local del dueño
$sql = "
    DELETE promociones FROM promociones 
    INNER JOIN locales ON promociones.codLocal = locales.codLocal 
    WHERE promociones.codPromo = $codPromo AND locales.codUsuario = $codUsuario
";

if ($conexion->query($sql)) {
    echo json_encode(['ok' => true]);
} else {
    echo json_encode(['ok' => false, 'error' => 'Error al eliminar']);
}
