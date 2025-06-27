<?php

// Funcion para formatear la fecha en español que vamos a usar despues
function formatearFechaManual($fechaISO) {
    $meses = [
        '01' => 'enero', '02' => 'febrero', '03' => 'marzo',
        '04' => 'abril', '05' => 'mayo', '06' => 'junio',
        '07' => 'julio', '08' => 'agosto', '09' => 'septiembre',
        '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'
    ];
    $fecha = new DateTime($fechaISO);
    $dia = $fecha->format('d');
    $mes = $meses[$fecha->format('m')];
    $anio = $fecha->format('Y');
    return "$dia de $mes de $anio";
}

// Función para subir de categoria al cliente, si usó 5 pasa de Inicial a Medium, y si usó 15 pasa a Premium
function verificarCategoriaCliente($conexion, $usuario_id) {
    $sql_uso = "SELECT COUNT(*) AS total FROM uso_promociones WHERE codUsuario = $usuario_id AND estado = 'aprobada'";
    $res_uso = $conexion->query($sql_uso);
    $cantidad = $res_uso->fetch_assoc()['total'];

    $sql_cat = "SELECT categoriaCliente FROM usuarios WHERE codUsuario = $usuario_id";
    $res_cat = $conexion->query($sql_cat);
    $categoria_actual = $res_cat->fetch_assoc()['categoriaCliente'];

    $nueva_categoria = $categoria_actual;

    if ($cantidad >= 15 && $categoria_actual !== 'Premium') {
        $nueva_categoria = 'Premium';
    } elseif ($cantidad >= 5 && $categoria_actual === 'Inicial') {
        $nueva_categoria = 'Medium';
    }

    if ($nueva_categoria !== $categoria_actual) {
        $conexion->query("UPDATE usuarios SET categoriaCliente = '$nueva_categoria' WHERE codUsuario = $usuario_id");
    }
}

?>