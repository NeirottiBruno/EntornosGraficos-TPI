<?php
include '../componentes/encabezado.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Shopping Plaza</title>
    <link rel="stylesheet" href="../assets/estilos/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <section class="position-relative" style="height: 420px; overflow: hidden;">
        <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center" ; padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
            <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222;">¡Bienvenido a Shopping Plaza!</h1>
        </div>
    </section>


    <section class="container-fluid margen-grande">
        <h1 class="mb-4 text-center">¡Secciones que te pueden interesar!</h1>
        <div class="row g-5">
            <div class="col-12 col-md-6 d-flex">
                <a href="locales.php" class="text-decoration-none flex-fill">
                    <div class="card text-bg-dark h-100">
                        <img src="../assets/imagen/promociones.jpeg" class="card-img" alt="Ir a promociones" style="height: 300px; object-fit: cover;">
                        <div class="card-img-overlay d-flex align-items-center justify-content-center">
                            <h1 class="fw-bold mb-3" style="font-size: 3.5rem; text-shadow: 2px 2px 8px #222;">Ir a Promociones</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 d-flex">
                <a href="locales.php" class="text-decoration-none flex-fill">
                    <div class="card text-bg-dark h-100">
                        <img src="../assets/imagen/locales.jpeg" class="card-img" alt="Ir a Locales" style="height: 300px; object-fit: cover;">
                        <div class="card-img-overlay d-flex align-items-center justify-content-center">
                            <h1 class="fw-bold mb-3" style="font-size: 3.5rem; text-shadow: 2px 2px 8px #222;">Ir a Locales</h1>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class=" container-fluid margen-grande fondo-personalizado">
        <h1 class="mb-4 text-center">¡Ultimas novedades!</h1>
        <div class="row row-cols-1 row-cols-3  g-4">

            <div class="col">
                <div class="card h-100">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a short card.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

<div class="container-fluid margen-grande">
    <h1 class="text-center mb-4">¡Encontranos!</h1>
    <div style="width: 100%; max-width: 100%; height: 350px; overflow: hidden; ">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26785.77062545234!2d-60.681763919906345!3d-32.94516549056678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95b7ab10c3a2cb0f%3A0x5d19f654fdac9e11!2sGALERIA%20PLAZA%20SARMIENTO!5e0!3m2!1ses!2ar!4v1750107627898!5m2!1ses!2ar"
            width="100%" height="100%" style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

    <?php include '../componentes/pie.php'; ?>
</body>

</html>