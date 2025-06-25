<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');

// SIMULACION sesión de dueño (hasta tener login real) -- BORRAR DESPUES
$_SESSION['usuario'] = 'giro@shopping.com';
$_SESSION['tipo_usuario'] = 'dueño de local';
$_SESSION['cod_usuario'] = 6;

if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'dueño de local') {
    header('Location: login.php');
    exit;
}

$codUsuario = $_SESSION['cod_usuario'];
$mensajeExito = false;
$tabActiva = $_GET['tab'] ?? 'datos';

// Obtener datos del local
$sql = "SELECT * FROM locales WHERE codUsuario = $codUsuario";
$result = $conexion->query($sql);
$local = $result->fetch_assoc();


// Procesar formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_datos'])) {
    $nombre = $conexion->real_escape_string($_POST['nombreLocal']);
    $rubro = $conexion->real_escape_string($_POST['rubroLocal']);
    // Logo
    $nuevoLogo = $local['logo'];
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
        $nombreArchivo = basename($_FILES['logo']['name']);
        $destino = "../assets/imagen/" . $nombreArchivo;
        move_uploaded_file($_FILES['logo']['tmp_name'], $destino);
        $nuevoLogo = $nombreArchivo;
    }
    $descripcion = $conexion->real_escape_string($_POST['descripcionLocal']);

    $conexion->query("UPDATE locales SET nombreLocal = '$nombre', rubroLocal = '$rubro', logo = '$nuevoLogo', descripcionLocal = '$descripcion' WHERE codUsuario = $codUsuario");
    $mensajeExito = true;

    // Actualizar datos para mostrar en formulario
    $sql = "SELECT * FROM locales WHERE codUsuario = $codUsuario";
    $local = $conexion->query($sql)->fetch_assoc();
}
?>




<div class="container my-4">
    <h3 class="mb-4">Panel de Gestión del Local</h3>

    <div class="panel-container">
        <!-- MENÚ LATERAL -->
        <div class="panel-menu nav flex-column nav-pills" id="menu-tabs" role="tablist">
            <button class="nav-link <?= ($tabActiva == 'promociones') ? '' : 'active' ?>" data-bs-toggle="pill" data-bs-target="#datos" type="button">Datos</button>
            <button class="nav-link <?= ($tabActiva == 'promociones') ? 'active' : '' ?>" data-bs-toggle="pill" data-bs-target="#promos" type="button">Promociones</button>
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#solicitudes" type="button">Solicitudes</button>
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#reportes" type="button">Reportes</button>
        </div>

        <!-- CONTENIDOS -->
        <div class="tab-content panel-content">
            <!-- DATOS -->
            <div class="tab-pane fade <?= ($tabActiva == 'promociones') ? '' : 'show active' ?>" id="datos">
                <h5>Datos del Local</h5>
                <?php if ($mensajeExito): ?>
                    <div class="alert alert-success alert-fade" style="margin-bottom: 1rem !important;">Cambios guardados correctamente.</div>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Nombre del Local</label>
                        <input type="text" name="nombreLocal" class="form-control" value="<?= $local['nombreLocal'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Rubro</label>
                        <select name="rubroLocal" class="form-select" required>
                            <?php
                            $rubros = ["indumentaria", "accesorios", "comida", "tecnología"];
                            foreach ($rubros as $r):
                                $sel = ($local['rubroLocal'] == $r) ? 'selected' : '';
                                echo "<option value='$r' $sel>" . ucfirst($r) . "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Logo actual:</label><br>
                        <img src="../assets/imagen/<?= $local['logo'] ?>" alt="Logo actual" style="max-height: 60px;"><br>
                        <label class="mt-2">Cambiar logo:</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Descripción del Local</label>
                        <textarea name="descripcionLocal" class="form-control"><?= $local['descripcionLocal'] ?></textarea>
                    </div>
                    <button type="submit" name="guardar_datos" class="btn btn-dark">Guardar Cambios</button>
                </form>
            </div>

            <!-- PROMOCIONES -->
            <div class="tab-pane fade <?= ($tabActiva == 'promociones') ? 'show active' : '' ?>" id="promos">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Promociones propias</h5>
                    <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevaPromo">+ Nueva Promoción</a>
                </div>


                <div class="row" id="contenedorPromos">
                    <?php
                    $res = $conexion->query("SELECT * FROM promociones WHERE codLocal = " . $local['codLocal']);
                    if ($res && $res->num_rows > 0):
                        while ($p = $res->fetch_assoc()):
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4 mb-3" id="promo_<?= $p['codPromo'] ?>">
                        <div class="border rounded p-2 h-100">
                            <p><strong><?= $p['textoPromo'] ?></strong></p>
                            <p>
                                <small>Vigencia hasta: <?= $p['fechaHastaPromo'] ?></small><br>
                                <small>Categoria destino: <?= $p['categoriaCliente'] ?></small><br>
                                <small>Días de vigencia: <?= $p['diasSemana'] ?></small>
                            </p>
                            Estado:&nbsp;
                            <span style="margin-bottom: -5px;" class="badge bg-<?=
                                $p['estadoPromo'] === 'aprobada' ? 'success' :
                                ($p['estadoPromo'] === 'pendiente' ? 'warning' : 'danger') ?>">
                                <?= ucfirst($p['estadoPromo']) ?>
                            </span>
                            <button class="btn btn-sm btn-outline-danger w-100 mt-2 btn-eliminar" data-id="<?= $p['codPromo'] ?>">Eliminar</button>
                        </div>
                    </div>
                    <?php endwhile; else: ?>
                        <p>No hay promociones registradas.</p>
                    <?php endif; ?>
                </div>

                <!-- Modal-->
                <div class="modal fade" id="modalNuevaPromo" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="formNuevaPromo">
                                <div class="modal-header">
                                    <h4 class="modal-title">Crear Nueva Promoción</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Texto Promoción</label>
                                        <input type="text" name="textoPromo" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Categoría destino</label>
                                        <select name="categoriaCliente" class="form-select" required>
                                            <option value="Inicial">Inicial</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Premium">Premium</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Vigencia hasta</label>
                                        <input type="date" name="fechaHastaPromo" class="form-control" required min="<?= date('Y-m-d') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label d-block">Días vigentes</label>
                                        <div class="row">
                                            <?php
                                            $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                            foreach ($dias as $dia): ?>
                                                <div class="form-check col-6" stlye="padding: 5px 0px !important; margin-left: 0px !important;">
                                                    <input class="form-check-input" type="checkbox" name="dias[]" value="<?= $dia ?>" id="dia<?= $dia ?>">
                                                    <label class="form-check-label" for="dia<?= $dia ?>"><?= $dia ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SOLICITUDES -->
            <div class="tab-pane fade" id="solicitudes">
                <h5>Solicitudes Pendientes</h5>
                <table class="table table-bordered">
                    <thead><tr><th>Cliente</th><th>Promoción</th><th>Fecha</th><th>Código</th><th>Acciones</th></tr></thead>
                    <tbody>
                        <?php
                        $sql = "
                            SELECT u.id, u.codigoGenerado, us.nombreUsuario, p.textoPromo, u.fechaSolicitud 
                            FROM uso_promociones u
                            INNER JOIN usuarios us ON u.codUsuario = us.codUsuario
                            INNER JOIN promociones p ON u.codPromo = p.codPromo
                            WHERE u.estado = 'pendiente' AND p.codLocal = " . $local['codLocal'];
                        $res = $conexion->query($sql);
                        if ($res && $res->num_rows > 0):
                            while ($sol = $res->fetch_assoc()):
                        ?>
                        <tr id="uso_<?= $sol['id'] ?>">
                            <td><?= $sol['nombreUsuario'] ?></td>
                            <td><?= $sol['textoPromo'] ?></td>
                            <td><?= $sol['fechaSolicitud'] ?></td>
                            <td><?= $sol['codigoGenerado'] ?></td>
                            <td style="display: flex;">
                                <button data-id="<?= $sol['id'] ?>" class="btn btn-sm btn-success btn-aprobar" style="width: 49%;">Aprobar</button>
                                <button data-id="<?= $sol['id'] ?>" class="btn btn-sm btn-danger btn-rechazar" style="width: 49%; margin-left: 2%;">Rechazar</button>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="5">No hay solicitudes pendientes.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- REPORTES -->
            <div class="tab-pane fade" id="reportes">
                <h5>Reporte de Usos</h5>
                <button class="btn btn-outline-primary mb-3" onclick="imprimirReporte()"><i class="fa fa-print"></i> Imprimir reporte</button>
                <table class="table table-striped">
                    <thead><tr><th>Promoción</th><th>Cantidad de usos</th></tr></thead>
                    <tbody>
                        <?php
                        $sql = "
                            SELECT p.textoPromo, COUNT(u.id) AS total
                            FROM promociones p
                            LEFT JOIN uso_promociones u ON p.codPromo = u.codPromo AND u.estado = 'aprobada'
                            WHERE p.codLocal = " . $local['codLocal'] . "
                            GROUP BY p.codPromo";
                        $res = $conexion->query($sql);
                        if ($res && $res->num_rows > 0):
                            while ($r = $res->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $r['textoPromo'] ?></td>
                            <td><?= $r['total'] ?></td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="2">Sin datos aún.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Crear Promoción -->
<script>
const form = document.getElementById('formNuevaPromo');
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const checkboxes = document.querySelectorAll('input[name="dias[]"]:checked');
    if (checkboxes.length === 0) {
        alert("Selecciona al menos un día de vigencia");
        return;
    }

    const diasSeleccionados = Array.from(checkboxes).map(cb => cb.value).join(',');
    const datos = new FormData(form);
    datos.set('diasSemana', diasSeleccionados); // sobrescribe el array por texto plano

    const res = await fetch('../../Backend/crearPromo.php', {
        method: 'POST',
        body: datos
    });
    const json = await res.json();

    if (json.ok) {
        const div = document.createElement('div');
        div.innerHTML = json.html;
        document.getElementById('contenedorPromos').prepend(div);
        bootstrap.Modal.getInstance(document.getElementById('modalNuevaPromo')).hide();
        form.reset();
        window.location.href = window.location.pathname + '?tab=promociones';
    } else {
        alert("Error al guardar." + json.error);
    }
});
</script>

<!-- Eliminar Promocion -->
<script>
document.querySelectorAll('.btn-eliminar').forEach(btn => {
    btn.addEventListener('click', async () => {
        if (!confirm("¿Estás seguro de eliminar esta promoción?")) return;

        const codPromo = btn.dataset.id;

        const res = await fetch('../../Backend/eliminarPromo.php', {
            method: 'POST',
            body: new URLSearchParams({ codPromo })
        });

        const json = await res.json();
        if (json.ok) {
            document.getElementById('promo_' + codPromo).remove();
        } else {
            alert("Error al eliminar.");
        }
    });
});
</script>

<!-- Gestionar Solicitud -->
<script>
document.querySelectorAll('.btn-aprobar, .btn-rechazar').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;
        const accion = btn.classList.contains('btn-aprobar') ? 'aprobada' : 'rechazada';

        const confirmar = confirm(`¿Seguro que deseas marcar esta solicitud como ${accion}?`);
        if (!confirmar) return;

        const res = await fetch('../../Backend/gestionarSolicitud.php', {
            method: 'POST',
            body: new URLSearchParams({ id, accion })
        });

        const json = await res.json();
        if (json.ok) {
            alert(`Solicitud ${accion} correctamente`);
            document.getElementById('uso_' + id).remove();
            window.location.reload();
        } else {
            alert("Error: " + json.error);
        }
    });
});
</script>

<!-- Imprimir Reporte -->
<script>
function imprimirReporte() {
    const contenido = document.querySelector('#reportes').innerHTML;
    const ventana = window.open('', '', 'width=800,height=600');
    ventana.document.write(`
        <html>
        <head>
            <title>Reporte de usos</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
            <style>
                body { padding: 20px; }
                h5 { margin-bottom: 20px; }
            </style>
        </head>
        <body onload="window.print(); setTimeout(() => window.close(), 100);">
            ${contenido}
        </body>
        </html>
    `);
    ventana.document.close();
}
</script>

<?php include('../componentes/pie.php'); ?>
