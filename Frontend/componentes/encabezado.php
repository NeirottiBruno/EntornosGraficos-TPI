<?php
// Iniciar sesión para detección de login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);

// Detectar si el usuario está logueado y su tipo
$usuario_logueado = isset($_SESSION['usuario']);
$tipo_usuario = $_SESSION['tipo_usuario'] ?? null; // admin / dueño / cliente
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/estilos.css">
<link rel="stylesheet" href="../assets/fontawesome/css/fontawesome.css"/>
<link rel="stylesheet" href="../assets/fontawesome/css/brands.css"/>
<link rel="stylesheet" href="../assets/fontawesome/css/solid.css"/>
<link rel="icon" type="image/x-icon" href="../assets/imagen/favicon.png">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<header class="top-header">
    <div class="top-bar py-2 bg-light">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start" style="width: 100%;">
            <?php if (!$usuario_logueado): ?>
                <span class="welcome-msg">¡Bienvenido a Rosario Plaza Shopping!</span>
            <?php else: ?>
                <span class="welcome-msg">Hola, <strong><?= $_SESSION['usuario'] ?></strong></span>
            <?php endif; ?>
            <div class="top-links mt-2 mt-md-0">
                <?php if (!$usuario_logueado): ?>
                    <a href="/Frontend/paginas/login.php"><i class="fa fa-sign-in"></i> Iniciar sesión</a>&nbsp;&nbsp;&nbsp;|&nbsp;
                    <a href="/Frontend/paginas/registro.php"><i class="fa fa-user"></i> Registrarse</a>
                <?php else: ?>
                    <?php if ($tipo_usuario === 'administrador'): ?>
                        <a href="/Frontend/paginas/panelAdministrador.php"><i class="fa fa-cogs"></i> Panel Administración</a>
                    <?php elseif ($tipo_usuario === 'dueño de local'): ?>
                        <a href="/Frontend/paginas/panelDueño.php"><i class="fa fa-store"></i> Mi Local</a>
                    <?php elseif ($tipo_usuario === 'cliente'): ?>
                        <a href="/Frontend/paginas/panelCliente.php"><i class="fa fa-user-circle"></i> Mi Perfil</a>
                    <?php endif; ?>
                    &nbsp;&nbsp;&nbsp;|&nbsp;
                    <a href="/Frontend/paginas/logout.php"><i class="fa fa-sign-out"></i> Cerrar sesión</a>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <a class="navbar-brand mb-0" href="/Frontend/paginas/index.php"><img class="logo-principal" alt="Logo Rosario Plaza" width="180" src="../assets/imagen/logo-horizontal-rosario-plaza-shopping.png"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'index.php') ? 'active' : '' ?>" href="/Frontend/paginas/index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'nosotros.php') ? 'active' : '' ?>" href="/Frontend/paginas/nosotros.php">Nosotros</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'locales.php') ? 'active' : '' ?>" href="/Frontend/paginas/locales.php">Locales</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'promociones.php') ? 'active' : '' ?>" href="/Frontend/paginas/promociones.php">Promociones</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'novedades.php') ? 'active' : '' ?>" href="/Frontend/paginas/novedades.php">Novedades</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'contacto.php') ? 'active' : '' ?>" href="/Frontend/paginas/contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>