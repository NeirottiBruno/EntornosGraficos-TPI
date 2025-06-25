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

$codUsuario = $_SESSION['cod_usuario'];
$id = intval($_POST['id'] ?? 0);
$accion = $_POST['accion'] ?? '';

if (!in_array($accion, ['aprobada', 'rechazada'])) {
    echo json_encode(['ok' => false, 'error' => 'Acción inválida']);
    exit;
}

// Confirmar que la solicitud corresponde a una promo del dueño
$sql = "
    UPDATE uso_promociones up
    INNER JOIN promociones p ON up.codPromo = p.codPromo
    INNER JOIN locales l ON p.codLocal = l.codLocal
    SET up.estado = '$accion'
    WHERE up.id = $id AND l.codUsuario = $codUsuario
";

$ok = $conexion->query($sql);
echo json_encode(['ok' => $ok]);
?>