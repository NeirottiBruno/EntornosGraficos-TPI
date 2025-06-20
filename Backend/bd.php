<?php
/*
$host = "auth-db728.hstgr.io";
$usuario = "u683936510_grupo9";
$contrasena = "##\$g8M0j";
$base_de_datos = "u683936510_u683936510";
*/

// Usamos temporalmente la local porque xampp no puede leer bbdd de hostinger
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "shopping";


$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar charset
$conexion->set_charset("utf8");
?>