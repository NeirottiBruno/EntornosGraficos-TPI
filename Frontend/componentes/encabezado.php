<?php
// Iniciar sesión para detección de login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detectar si el usuario está logueado y su tipo
$usuario_logueado = isset($_SESSION['usuario']);
$tipo_usuario = $_SESSION['tipo_usuario'] ?? null; // admin / dueño / cliente
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/estilos.css">
<link rel="stylesheet" href="../assets/fontawesome/css/fontawesome.css"/>
<link rel="stylesheet" href="../assets/fontawesome/css/brands.css"/>
<link rel="stylesheet" href="../assets/fontawesome/css/solid.css"/>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<header class="top-header">
    <div class="top-bar py-2 bg-light">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start" style="width: 100%;">
            <span class="welcome-msg">Bienvenido a Shopping Rosario</span>
            <div class="top-links mt-2 mt-md-0">
                <a href="/Frontend/paginas/login.php"><i class="fa fa-sign-in" style="font-size: 13px; margin-bottom: -2px !important;"></i> Iniciar sesión</a>&nbsp;&nbsp;&nbsp;|&nbsp;
                <a href="/Frontend/paginas/registro.php"><i class="fa fa-user" style="font-size: 13px; margin-bottom: -2px !important;"></i> Registrarse</a>
            </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <a class="navbar-brand mb-0" href="/TPI/Frontend/paginas/index.php">🛍️ Plaza Shopping Rosario</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/TPI/Frontend/paginas/index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="/TPI/Frontend/paginas/nosotros.php">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="/TPI/Frontend/paginas/locales.php">Locales</a></li>
                    <li class="nav-item"><a class="nav-link" href="/TPI/Frontend/paginas/promociones.php">Promociones</a></li>
                    <li class="nav-item"><a class="nav-link" href="/TPI/Frontend/paginas/novedades.php">Novedades</a></li>
                    <li class="nav-item"><a class="nav-link" href="/TPI/Frontend/paginas/contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>