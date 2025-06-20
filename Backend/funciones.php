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

?>