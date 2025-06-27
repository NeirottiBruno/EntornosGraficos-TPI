<?php
include '../componentes/encabezado.php';
include '../../Backend/bd.php';

// Consultar las noticias ordenadas por fecha
$sql = "SELECT * FROM novedades ORDER BY fecha_publicacion DESC";
$result = $conexion->query($sql);
?>

<section class="position-relative" style="height: 420px; overflow: hidden;">
    <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
    <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
        <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222; overflow: hidden;">Novedades</h1>
    </div>
</section>

<?php
// Paginación
$noticiasPorPagina = 4;
$paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

// Contar total de novedades
$totalSql = "SELECT COUNT(*) as total FROM novedades";
$totalResult = $conexion->query($totalSql);
$totalFilas = $totalResult ? $totalResult->fetch_assoc()['total'] : 0;
$totalPaginas = ceil($totalFilas / $noticiasPorPagina);

// Calcular offset
$offset = ($paginaActual - 1) * $noticiasPorPagina;

// Consultar novedades para la página actual
$sqlPaginado = "SELECT * FROM novedades ORDER BY fecha_publicacion DESC LIMIT $noticiasPorPagina OFFSET $offset";
$resultPaginado = $conexion->query($sqlPaginado);
?>

<div class="container margen-grande">
    <div class="row">
        <?php if ($resultPaginado && $resultPaginado->num_rows > 0): ?>
            <?php while ($novedad = $resultPaginado->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($novedad['imagen'])): ?>
                            <img 
                                src="../assets/imagen/<?= htmlspecialchars($novedad['imagen']) ?>" 
                                class="card-img-top"
                                alt="Imagen de la novedad"
                                style="object-fit: cover; width: 100%; height: 250px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;"
                            >
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($novedad['titulo']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($novedad['contenido'])) ?></p>
                        </div>
                        <div class="card-footer text-muted">
                            Publicado el <?= date("d/m/Y", strtotime($novedad['fecha_publicacion'])) ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay novedades por el momento.</p>
        <?php endif; ?>
    </div>

    <!-- Paginación -->
    <?php if ($totalPaginas > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $paginaActual <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $paginaActual - 1 ?>" tabindex="-1">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= $i == $paginaActual ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $paginaActual >= $totalPaginas ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $paginaActual + 1 ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php include '../componentes/pie.php'; ?>