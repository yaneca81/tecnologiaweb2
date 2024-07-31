<?php
include '../config/config.php';

function obtenerEstadisticasUsuarios() {
    global $conn;
    $sql = "SELECT rol, COUNT(*) as cantidad FROM usuario GROUP BY rol";
    $result = $conn->query($sql);
    $estadisticas = [];
    while ($row = $result->fetch_assoc()) {
        $estadisticas[$row['rol']] = $row['cantidad'];
    }
    return $estadisticas;
}

function obtenerEstadisticasPostulaciones() {
    global $conn;
    $sql = "SELECT estado, COUNT(*) as cantidad FROM postulacion GROUP BY estado";
    $result = $conn->query($sql);
    $estadisticas = [];
    while ($row = $result->fetch_assoc()) {
        $estadisticas[$row['estado']] = $row['cantidad'];
    }
    return $estadisticas;
}

function obtenerEstadisticasCategorias() {
    global $conn;
    $categorias = ['Tecnología', 'Salud', 'Educación', 'Administración', 'Comercio', 'Otras'];
    $estadisticas = array_fill_keys($categorias, 0);

    $sql = "SELECT categoria, COUNT(*) as cantidad FROM empleo JOIN postulacion ON empleo.id = postulacion.id_empleo GROUP BY categoria";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        if (array_key_exists($row['categoria'], $estadisticas)) {
            $estadisticas[$row['categoria']] = $row['cantidad'];
        } else {
            $estadisticas['Otras'] += $row['cantidad'];
        }
    }
    return $estadisticas;
}

function obtenerEstadisticasTipos() {
    global $conn;
    $tipos = ['medio tiempo', 'tiempo completo', 'medio tiempo|tiempo completo'];
    $estadisticas = array_fill_keys($tipos, 0);

    $sql = "SELECT horario, COUNT(*) as cantidad FROM empleo JOIN postulacion ON empleo.id = postulacion.id_empleo GROUP BY horario";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        if (array_key_exists($row['tipo'], $estadisticas)) {
            $estadisticas[$row['tipo']] = $row['cantidad'];
        } else {
            $estadisticas['Otras'] += $row['cantidad'];
        }
    }
    return $estadisticas;
}
?>
