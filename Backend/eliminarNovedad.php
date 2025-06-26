<?php
session_start();
include('bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM novedades WHERE id = $id";
    if ($conexion->query($sql)) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => $conexion->error]);
    }
}
