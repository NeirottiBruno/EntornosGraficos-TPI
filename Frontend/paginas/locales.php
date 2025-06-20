<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');

// Variables para filtros y ordenamiento
$codigoBuscado = $_GET['codigo'] ?? '';
$rubroBuscado = $_GET['rubro'] ?? '';
$orden = $_GET['orden'] ?? 'asc';

// Consulta SQL base
$sql = "SELECT * FROM locales WHERE 1";

// Filtro por código
if (!empty($codigoBuscado)) {
    $sql .= " AND codLocal = " . intval($codigoBuscado);
}

// Filtro por rubro
if (!empty($rubroBuscado)) {
    $sql .= " AND rubroLocal = '" . $conexion->real_escape_string($rubroBuscado) . "'";
}

// Ordenamiento
$sql .= " ORDER BY nombreLocal " . ($orden === 'desc' ? 'DESC' : 'ASC');

// Ejecutar consulta
$resultado = $conexion->query($sql);
?>

<div class="container my-4">
    <div class="row">

        <!-- Filtros -->
        <div class="col-12 col-md-3 mb-4">
            <div class="filtros-promos p-3 border rounded bg-white">
                <form method="GET">
                    <label for="codigo">Buscar por Código:</label>
                    <input type="number" name="codigo" id="codigo" class="form-control mb-3" value="<?= htmlspecialchars($codigoBuscado) ?>">

                    <label for="rubro">Filtrar por Rubro:</label>
                    <select name="rubro" id="rubro" class="form-select mb-3">
                        <option stlye="text-transform: capitalize;" value="">-- Todos --</option>
                        <?php
                        $rubros = ["accesorios", "tecnología", "comida", "indumentaria"];
                        foreach ($rubros as $r) {
                            $selected = ($r === $rubroBuscado) ? 'selected' : '';
                            echo "<option style='text-transform: capitalize;' value=\"$r\" $selected>$r</option>";
                        }
                        ?>
                    </select>

                    <label for="orden">Ordenar:</label>
                    <select name="orden" id="orden" class="form-select mb-3">
                        <option value="asc" <?= $orden === 'asc' ? 'selected' : '' ?>>A-Z</option>
                        <option value="desc" <?= $orden === 'desc' ? 'selected' : '' ?>>Z-A</option>
                    </select>

                    <button type="submit" class="btn btn-dark btn-sm w-100">Aplicar filtros</button>
                    <?php if (!empty($codigoBuscado) || !empty($rubroBuscado)): ?>
                        <a href="locales.php" class="btn btn-outline-secondary btn-sm mt-2 w-100">Borrar filtros</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Tarjetas -->
        <div class="col-12 col-md-9">
            <div class="row">
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($local = $resultado->fetch_assoc()): ?>
                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            <div class="promo-card border p-3 rounded h-100 d-flex flex-column">
                                <div class="promo-logo text-start mb-3">
                                    <img src="../assets/imagen/<?= $local['logo'] ?>" alt="Logo <?= $local['nombreLocal'] ?>" class="img-fluid" style="max-height: 50px;">
                                </div>
                                <div class="promo-info flex-fill">
                                    <h5><?= $local['nombreLocal'] ?></h5>
                                    <p class="caracteristicas" style="text-transform: capitalize;">Cód. <?= $local['codLocal'] ?> - <?= $local['rubroLocal'] ?></p>
                                </div>
                                <a href="detalleLocal.php?id=<?= $local['codLocal'] ?>" class="btn-texto">Explorar</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No se encontraron locales con esos criterios.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('../componentes/pie.php'); ?>
