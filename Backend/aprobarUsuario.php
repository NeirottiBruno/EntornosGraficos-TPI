<?php
session_start();
include('bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $sql = "UPDATE usuarios SET estadoCuenta = 'activo' WHERE codUsuario = $id";
    if ($conexion->query($sql)) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => $conexion->error]);
    }
}
?>
