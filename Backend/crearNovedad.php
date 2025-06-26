<?php
session_start();
include('bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $contenido = $conexion->real_escape_string($_POST['contenido']);
    $fecha = $_POST['fecha_publicacion'];
    $imagen = '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaDestino = "../Frontend/assets/imagen/" . $nombreArchivo;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        $imagen = $nombreArchivo;
    }

    $sql = "INSERT INTO novedades (titulo, contenido, fecha_publicacion, imagen)
            VALUES ('$titulo', '$contenido', '$fecha', '$imagen')";

    if ($conexion->query($sql)) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => $conexion->error]);
    }
}
