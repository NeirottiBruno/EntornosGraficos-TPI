<?php
include '../componentes/encabezado.php';
include '../../Backend/bd.php';

// Consulta para obtener las 3 últimas novedades
$sql = "SELECT * FROM novedades ORDER BY fecha_publicacion DESC LIMIT 3";
$result = $conexion->query($sql);
?>


<section class="position-relative" style="height: 420px; overflow: hidden;">
    <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
    <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
        <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222;">¡Bienvenido a Shopping Plaza!</h1>
    </div>
</section>


<section class="container margen-grande">
    <h1 class="mb-5 text-center fw-semibold" style="font-size: 2.5rem; letter-spacing: 1px;">
        ¡Secciones que te pueden interesar!
    </h1>
    <div class="row g-4 justify-content-center">
        <div class="col-12 col-md-6 d-flex">
            <a href="promociones.php" class="modern-card flex-fill">
                <div class="modern-card-img" style="background-image: url('../assets/imagen/promociones.jpeg');">
                    <div class="modern-card-overlay">
                        <span class="modern-card-title">Ir a Promociones</span>
                        <span class="modern-card-arrow">&rarr;</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 d-flex">
            <a href="locales.php" class="modern-card flex-fill">
                <div class="modern-card-img" style="background-image: url('../assets/imagen/locales.jpeg');">
                    <div class="modern-card-overlay">
                        <span class="modern-card-title">Ir a Locales</span>
                        <span class="modern-card-arrow">&rarr;</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="container-fluid margen-grande fondo-personalizado">
    <h1 class="mb-5 text-center fw-semibold" style="font-size: 2.5rem; letter-spacing: 1px;">
        ¡Ultimas Novedades!
    </h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($noticia = $result->fetch_assoc()): ?>
                <div class="col">
                    <a href="novedades.php?id=<?= urlencode($noticia['id']) ?>" class="novedad-link">
                        <div class="card h-100 shadow-sm novedad-card">
                            <?php if (!empty($noticia['imagen'])): ?>
                                <img src="../assets/imagen/<?= htmlspecialchars($noticia['imagen']) ?>"
                                     class="card-img-top"
                                     style="object-fit: cover; width: 100%; height: 220px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                                <p class="card-text"><?= nl2br(htmlspecialchars($noticia['contenido'])) ?></p>
                            </div>
                            <div class="card-footer text-muted">
                                Publicado el <?= date("d/m/Y", strtotime($noticia['fecha_publicacion'])) ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No hay novedades para mostrar.</p>
        <?php endif; ?>
    </div>
</section>


<div class="container-fluid margen-mapa">
    <h1 class="mb-5 text-center fw-semibold" style="font-size: 2.5rem; letter-spacing: 1px;">
        ¡Encontranos!
    </h1>
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