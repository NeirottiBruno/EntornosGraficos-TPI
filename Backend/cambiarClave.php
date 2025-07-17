<?php
include('bd.php');
session_start();

if (!isset($_SESSION['cod_usuario'])) {
    header("Location: ../Frontend/login.php");
    exit;
}

$codUsuario = $_SESSION['cod_usuario'];
$nuevaClave = $_POST['nuevaClave'] ?? '';
$confirmarClave = $_POST['confirmarClave'] ?? '';
$origen = $_POST['origen'] ?? '../Frontend/index.php'; // Por si no lo pasan

// Normalizar: quitar parámetros previos como ?cambio=error para evitar duplicaciones
$origen = strtok($origen, '?');

if ($nuevaClave !== $confirmarClave) {
    header("Location: $origen?cambio=error");
    exit;
}

$sql = "UPDATE usuarios SET claveUsuario = ? WHERE codUsuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("si", $nuevaClave, $codUsuario);

if ($stmt->execute()) {
    header("Location: $origen?cambio=ok");
} else {
    header("Location: $origen?cambio=error");
}

$stmt->close();
$conexion->close();
