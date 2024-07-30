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
?>
