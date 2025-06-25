<?php
include_once('../../Backend/funciones.php');

function mostrarTarjetaPromo($promo, $conexion, $usuarioLogueado, $codUsuario, $categoriaUsuario) {
    ?>
    <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="promo-card border p-3 rounded h-100 d-flex flex-column">
            <?php if (isset($promo['logo'])): ?>
                <div class="promo-logo mb-2">
                    <img src="../assets/imagen/<?= $promo['logo'] ?>" alt="Logo Local" class="img-fluid">
                </div>
            <?php endif; ?>
            <div class="promo-info flex-fill">
                <h5><?= $promo["textoPromo"] ?></h5>
                <?php if (isset($promo["nombreLocal"])): ?>
                    <small class="text-muted"><em><?= $promo["nombreLocal"] ?></em></small>
                    <p class="caracteristicas" style="text-transform: capitalize;"><strong>Rubro:</strong> <?= $promo["rubroLocal"] ?? '-' ?></p>
                <?php endif; ?>
                <p class="caracteristicas"><strong>Válido hasta:</strong> <?= formatearFechaManual($promo["fechaHastaPromo"]) ?></p>
            </div>
            <?php
            $codPromo = $promo['codPromo'];
            $sqlUso = "SELECT estado, codigoGenerado FROM uso_promociones WHERE codPromo = $codPromo AND codUsuario = $codUsuario";
            $resUso = $conexion->query($sqlUso);
            $estadoUso = null;
            $codigoUso = null;

            if ($resUso && $resUso->num_rows > 0) {
                $rowUso = $resUso->fetch_assoc();
                $estadoUso = $rowUso['estado'];
                $codigoUso = $rowUso['codigoGenerado'];
            }

            $niveles = ['Inicial' => 1, 'Medium' => 2, 'Premium' => 3];
            $nivelCliente = $niveles[$categoriaUsuario] ?? 0;
            $nivelPromo = $niveles[$promo['categoriaCliente']] ?? 0;

            if ($nivelCliente == 0) {
                echo "";
            } else if ($nivelCliente >= $nivelPromo) {
                if ($estadoUso === 'aprobada') {
                    echo "<div class='alert alert-success'>Aprobada. Código de promoción: <strong>$codigoUso</strong></div>";
                } elseif ($estadoUso === 'pendiente') {
                    echo "<div class='alert alert-warning mt-2'>Promoción solicitada a la espera de aprobación</div>";
                } elseif ($estadoUso === 'rechazada') {
                    echo "<div class='alert alert-danger mt-2'>Soliciud rechazada por el Dueño.</div>";
                } else {
                    echo '
                    <form method="POST" style="width: 100%;">
                        <input type="hidden" name="solicitar" value="' . $promo['codPromo'] . '">
                        <button type="submit" class="btn btn-solicitar">
                            Solicitar Promoción <i class="fa fa-plus"></i>
                        </button>
                    </form>';
                }
            } else {
                echo "<div class='alert alert-danger'>Tu categoría no puede solicitar esta promoción.</div>";
            }
            ?>
        </div>
    </div>
    <?php
}
?>
