<?php

$host = "localhost";
$usuario = "u683936510_grupo9";
$contrasena = "##\$g8M0j";
$base_de_datos = "u683936510_u683936510";

$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar charset
$conexion->set_charset("utf8");
?>