<?php
session_start();
include('bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombreLocal']);
    $ubicacion = $conexion->real_escape_string($_POST['ubicacionLocal']);
    $rubro = $conexion->real_escape_string($_POST['rubroLocal']);
    $descripcion = $conexion->real_escape_string($_POST['descripcionLocal']);
    $codUsuario = intval($_POST['codUsuario']);

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
        $nombreArchivo = basename($_FILES['logo']['name']);
        $destino = "../Frontend/assets/imagen/" . $nombreArchivo;
        move_uploaded_file($_FILES['logo']['tmp_name'], $destino);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Logo no enviado']);
        exit;
    }

    $sql = "INSERT INTO locales (nombreLocal, ubicacionLocal, rubroLocal, codUsuario, descripcionLocal, logo)
            VALUES ('$nombre', '$ubicacion', '$rubro', $codUsuario, '$descripcion', '$nombreArchivo')";

    if ($conexion->query($sql)) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => $conexion->error]);
    }
}
?>
