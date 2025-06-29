<?php
session_start();
include('bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $codLocal = intval($_POST['codLocal'] ?? 0);

    // Validaciones iniciales
    if (!$id || !$codLocal) {
        echo json_encode(['ok' => false, 'error' => 'Datos incompletos.']);
        exit;
    }

    // Verificar que el local existe
    $checkLocal = $conexion->prepare("SELECT codLocal, codUsuario FROM locales WHERE codLocal = ?");
    $checkLocal->bind_param("i", $codLocal);
    $checkLocal->execute();
    $localResult = $checkLocal->get_result();

    if ($localResult->num_rows === 0) {
        echo json_encode(['ok' => false, 'error' => 'El local no existe.']);
        exit;
    }

    $local = $localResult->fetch_assoc();

    // Asignar el local al usuario
    $asignar = $conexion->prepare("UPDATE locales SET codUsuario = ? WHERE codLocal = ?");
    $asignar->bind_param("ii", $id, $codLocal);
    if (!$asignar->execute()) {
        echo json_encode(['ok' => false, 'error' => 'Error al asignar local.']);
        exit;
    }

    // Activar al usuario
    $activar = $conexion->prepare("UPDATE usuarios SET estadoCuenta = 'activo' WHERE codUsuario = ?");
    $activar->bind_param("i", $id);
    if ($activar->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Error al activar usuario.']);
    }
}
?>