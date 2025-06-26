<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');

if (!isset($_SESSION['usuario']) || $_SESSION['tipoUsuario'] !== 'administrador') {
    header('Location: login.php');
    exit;
}

$tabActiva = $_GET['tab'] ?? 'usuarios';
?>

<div class="container my-4">
    <h3 class="mb-4">Panel de Administración</h3>

    <div class="panel-container">
        <!-- Menú lateral -->
        <div class="panel-menu nav flex-column nav-pills" role="tablist">
            <button class="nav-link <?= ($tabActiva == 'usuarios') ? 'active' : '' ?>" data-bs-toggle="pill" data-bs-target="#usuarios" type="button">Gestión usuarios</button>
            <button class="nav-link <?= ($tabActiva == 'promociones') ? 'active' : '' ?>" data-bs-toggle="pill" data-bs-target="#promociones" type="button" style="padding-right: 10px;">Gestión promociones</button>
            <button class="nav-link <?= ($tabActiva == 'locales') ? 'active' : '' ?>" data-bs-toggle="pill" data-bs-target="#locales" type="button">Gestión locales</button>
            <button class="nav-link <?= ($tabActiva == 'novedades') ? 'active' : '' ?>" data-bs-toggle="pill" data-bs-target="#novedades" type="button">Gestión novedades</button>
            <button class="nav-link <?= ($tabActiva == 'reportes_local') ? 'active' : '' ?>" data-bs-toggle="pill" data-bs-target="#reportes_local" type="button">Reportes Locales</button>
            <button class="nav-link <?= ($tabActiva == 'reportes_cliente') ? 'active' : '' ?>" data-bs-toggle="pill" data-bs-target="#reportes_cliente" type="button">Reportes Clientes</button>
        </div>

        <!-- Contenido de pestañas -->
        <div class="tab-content panel-content">
            <!-- GESTIÓN USUARIOS -->
            <div class="tab-pane fade <?= ($tabActiva == 'usuarios') ? 'show active' : '' ?>" id="usuarios">
                <h5>Usuarios pendientes de aprobación</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Estado actual</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT codUsuario, nombreUsuario, email, estadoCuenta FROM usuarios WHERE tipo_usuario = 'dueño de local' AND estadoCuenta != 'activo'";
                        $res = $conexion->query($sql);
                        if ($res && $res->num_rows > 0):
                            while ($usuario = $res->fetch_assoc()):
                        ?>
                        <tr id="usuario_<?= $usuario['codUsuario'] ?>">
                            <td><?= $usuario['nombreUsuario'] ?></td>
                            <td><?= $usuario['email'] ?></td>
                            <td><?= ucfirst($usuario['estadoCuenta']) ?></td>
                            <td>
                                <button class="btn btn-success btn-sm aprobar-usuario" data-id="<?= $usuario['codUsuario'] ?>">Aprobar</button>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="4">No hay usuarios pendientes.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- GESTIÓN PROMOCIONES -->
            <div class="tab-pane fade <?= ($tabActiva == 'promociones') ? 'show active' : '' ?>" id="promociones">
                <h5>Promociones Pendientes</h5>

                <div class="row">
                    <?php
                    $sql = "SELECT p.*, l.nombreLocal, l.logo FROM promociones p INNER JOIN locales l ON p.codLocal = l.codLocal WHERE p.estadoPromo = 'pendiente'";
                    $res = $conexion->query($sql);
                    if ($res && $res->num_rows > 0):
                        while ($promo = $res->fetch_assoc()):
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-3" id="promo_<?= $promo['codPromo'] ?>">
                        <div class="border p-3 rounded h-100 d-flex flex-column justify-content-between">
                            <div>
                                <img src="../assets/imagen/<?= $promo['logo'] ?>" alt="Logo" style="max-height: 40px;">
                                <h6 class="mt-2"><?= $promo['textoPromo'] ?></h6>
                                <small><strong>Local:</strong> <?= $promo['nombreLocal'] ?></small><br>
                                <small><strong>Días:</strong> <?= $promo['diasSemana'] ?></small><br>
                                <small><strong>Categoría:</strong> <?= $promo['categoriaCliente'] ?></small><br>
                                <small><strong>Vigencia:</strong> <?= $promo['fechaHastaPromo'] ?></small>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                <button class="btn btn-sm btn-danger btn-accion" data-id="<?= $promo['codPromo'] ?>" data-accion="rechazada">Rechazar</button>
                                <button class="btn btn-sm btn-success btn-accion" data-id="<?= $promo['codPromo'] ?>" data-accion="aprobada">Aprobar</button>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; else: ?>
                    <p class="text-muted">No hay promociones pendientes de aprobación.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- GESTIÓN LOCALES -->
            <div class="tab-pane fade <?= ($tabActiva == 'locales') ? 'show active' : '' ?>" id="locales">            
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Locales Registrados</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoLocal" style="width: 180px; margin-left: 20px;">+ Nuevo Local</button>
                    </div>

                    <div class="row g-3">
                        <?php
                        $sql = "SELECT l.*, u.nombreUsuario FROM locales l INNER JOIN usuarios u ON l.codUsuario = u.codUsuario";
                        $res = $conexion->query($sql);
                        if ($res && $res->num_rows > 0):
                            while ($local = $res->fetch_assoc()):
                        ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-3" id="local_<?= $local['codLocal'] ?>">
                            <div class="border rounded p-3 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <img src="../assets/imagen/<?= $local['logo'] ?>" alt="Logo" style="max-height: 30px;"><br>
                                    <strong><?= $local['nombreLocal'] ?></strong><br>
                                    <small><strong>Rubro:</strong> <?= $local['rubroLocal'] ?></small><br>
                                    <small><strong>Ubicación:</strong> <?= $local['ubicacionLocal'] ?></small><br>
                                    <small><strong>Usuario:</strong> <?= $local['nombreUsuario'] ?></small><br>
                                    <small><strong>Descripción:</strong> <?= $local['descripcionLocal'] ?></small>
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-danger w-100 btn-eliminar-local" data-id="<?= $local['codLocal'] ?>">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; else: ?>
                        <p class="text-muted">No hay locales registrados.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalNuevoLocal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="formNuevoLocal" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title">Nuevo Local</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label>Nombre</label>
                                        <input type="text" name="nombreLocal" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Ubicación</label>
                                        <input type="text" name="ubicacionLocal" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Rubro</label>
                                        <select name="rubroLocal" class="form-select" required>
                                            <?php
                                            $rubros = ['indumentaria', 'accesorios', 'comida', 'tecnología'];
                                            foreach ($rubros as $r) {
                                                echo "<option value='$r'>" . ucfirst($r) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label>Usuario Dueño</label>
                                        <select name="codUsuario" class="form-select" required>
                                            <?php
                                            $usrs = $conexion->query("SELECT codUsuario, nombreUsuario FROM usuarios WHERE tipoUsuario = 'dueño de local' AND estadoCuenta = 'activo'");
                                            while ($u = $usrs->fetch_assoc()) {
                                                echo "<option value='{$u['codUsuario']}'>{$u['nombreUsuario']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label>Descripción</label>
                                        <textarea name="descripcionLocal" class="form-control"></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Logo</label>
                                        <input type="file" name="logo" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade <?= ($tabActiva == 'novedades') ? 'show active' : '' ?>" id="novedades">               
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Gestión de Novedades</h5>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevaNovedad" style="width: 180px; margin-left: 20px;">+ Nueva Novedad</button>
                    </div>

                    <div class="row g-3">
                        <?php
                        $res = $conexion->query("SELECT * FROM novedades ORDER BY fecha_publicacion DESC");
                        if ($res && $res->num_rows > 0):
                            while ($n = $res->fetch_assoc()):
                        ?>
                        <div class="col-12 col-md-6 col-lg-4" id="novedad_<?= $n['id'] ?>">
                            <div class="border rounded p-3 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <?php if (!empty($n['imagen'])): ?>
                                        <img src="../assets/imagen/<?= $n['imagen'] ?>" alt="Imagen" class="img-fluid mb-2" style="max-height: 150px;">
                                    <?php endif; ?>
                                    <h6><?= $n['titulo'] ?></h6>
                                    <small class="text-muted"><?= date('d/m/Y', strtotime($n['fecha_publicacion'])) ?></small>
                                    <p class="mt-2"><?= $n['contenido'] ?></p>
                                </div>
                                <button class="btn btn-sm btn-danger mt-2 btn-eliminar-novedad" data-id="<?= $n['id'] ?>">Eliminar</button>
                            </div>
                        </div>
                        <?php endwhile; else: ?>
                        <p class="text-muted">No hay novedades cargadas.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modalNuevaNovedad" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="formNuevaNovedad" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Nueva Novedad</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label>Título</label>
                                            <input type="text" name="titulo" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Contenido</label>
                                            <textarea name="contenido" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label>Fecha de publicación</label>
                                            <input type="date" name="fecha_publicacion" class="form-control" required value="<?= date('Y-m-d') ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label>Imagen (opcional)</label>
                                            <input type="file" name="imagen" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade <?= ($tabActiva == 'reportes_local') ? 'show active' : '' ?>" id="reportes_local">
                <h5>Reporte Global por Local</h5>
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Local</th>
                            <th>Cantidad de promociones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT l.nombreLocal, COUNT(p.codPromo) AS cantidad_promos
                                FROM locales l
                                LEFT JOIN promociones p ON l.codLocal = p.codLocal
                                GROUP BY l.codLocal
                                ORDER BY cantidad_promos DESC";

                        $res = $conexion->query($sql);
                        if ($res && $res->num_rows > 0):
                            while ($fila = $res->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?= $fila['nombreLocal'] ?></td>
                                <td><?= $fila['cantidad_promos'] ?></td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="2" class="text-muted">No hay locales registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

            <div class="tab-pane fade <?= ($tabActiva == 'reportes_cliente') ? 'show active' : '' ?>" id="reportes_cliente">             
                <h5 class="mb-3">Reporte Global por Cliente</h5>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Cantidad de promociones usadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT u.nombreUsuario, COUNT(up.id) AS cantidad_usos
                                FROM usuarios u
                                LEFT JOIN uso_promociones up ON u.codUsuario = up.codUsuario AND up.estado = 'aprobada'
                                WHERE u.tipoUsuario = 'cliente'
                                GROUP BY u.codUsuario
                                ORDER BY cantidad_usos DESC";

                        $res = $conexion->query($sql);
                        if ($res && $res->num_rows > 0):
                            while ($fila = $res->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?= $fila['nombreUsuario'] ?></td>
                                <td><?= $fila['cantidad_usos'] ?></td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="2" class="text-muted">No hay clientes registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Aprobar usuario -->
<script>
document.querySelectorAll('.aprobar-usuario').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;
        if (!confirm("¿Aprobar este usuario?")) return;

        const res = await fetch('../../Backend/aprobarUsuario.php', {
            method: 'POST',
            body: new URLSearchParams({ id })
        });

        const json = await res.json();
        if (json.ok) {
            document.getElementById('usuario_' + id).remove();
        } else {
            alert("Error: " + json.error);
        }
    });
});
</script>

<!-- Gestionar Promociones -->
<script>
document.querySelectorAll('.btn-accion').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;
        const accion = btn.dataset.accion;

        if (!confirm(`¿Seguro que deseas marcar esta promoción como ${accion}?`)) return;

        const res = await fetch('../../Backend/gestionarPromociones.php', {
            method: 'POST',
            body: new URLSearchParams({ id, accion })
        });

        const json = await res.json();
        if (json.ok) {
            document.getElementById('promo_' + id).remove();
        } else {
            alert("Error: " + json.error);
        }
    });
});
</script>

<!-- Gestión de Locales -->
<script>
// Crear Local
document.getElementById('formNuevoLocal').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const datos = new FormData(form);

    const res = await fetch('../../Backend/crearLocal.php', {
        method: 'POST',
        body: datos
    });

    const json = await res.json();
    if (json.ok) {
        alert("Local creado correctamente");
        window.reload();
    } else {
        alert("Error: " + json.error);
    }
});
// Eliminar Local
document.querySelectorAll('.btn-eliminar-local').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;
        if (!confirm("¿Eliminar este local?")) return;

        const res = await fetch('../../Backend/eliminarLocal.php', {
            method: 'POST',
            body: new URLSearchParams({ id })
        });

        const json = await res.json();
        if (json.ok) {
            document.getElementById('local_' + id).remove();
        } else {
            alert("Error: " + json.error);
        }
    });
});
</script>

<!-- Ajustar ancho panel -->
<script>
document.querySelectorAll('[data-bs-toggle="pill"]').forEach(btn => {
    btn.addEventListener('shown.bs.tab', function (e) {
        const target = e.target.getAttribute('data-bs-target'); // ej: '#locales'
        const menu = document.querySelector('.panel-menu');

        if (target === '#locales') {
            menu.style.width = '700px';
        } else {
            menu.style.width = '';
        }
    });
});
</script>

<!-- Gestión de Novedades -->
<script>
// Crear novedad
document.getElementById('formNuevaNovedad').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const datos = new FormData(form);

    const res = await fetch('../../Backend/crearNovedad.php', {
        method: 'POST',
        body: datos
    });

    const json = await res.json();
    if (json.ok) {
        alert("Novedad creada correctamente");
        window.location.href = window.location.pathname + '?tab=novedades';
    } else {
        alert("Error: " + json.error);
    }
});
// Eliminar novedad
document.querySelectorAll('.btn-eliminar-novedad').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;
        if (!confirm("¿Eliminar esta novedad?")) return;

        const res = await fetch('../../Backend/eliminarNovedad.php', {
            method: 'POST',
            body: new URLSearchParams({ id })
        });

        const json = await res.json();
        if (json.ok) {
            document.getElementById('novedad_' + id).remove();
        } else {
            alert("Error: " + json.error);
        }
    });
});
</script>


<?php include('../componentes/pie.php'); ?>
