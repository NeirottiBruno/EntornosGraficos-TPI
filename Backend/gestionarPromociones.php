<?php
session_start();
include('bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod = intval($_POST['id']);
    $accion = $_POST['accion']; // 'aprobada' o 'rechazada'

    if (!in_array($accion, ['aprobada', 'rechazada'])) {
        echo json_encode(['ok' => false, 'error' => 'Acción inválida']);
        exit;
    }

    $sql = "UPDATE promociones SET estadoPromo = '$accion' WHERE codPromo = $cod";
    if ($conexion->query($sql)) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => $conexion->error]);
    }
}
