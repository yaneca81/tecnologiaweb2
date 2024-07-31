<?php
include 'includes/conexion.php';

function listarTalleres() {
    global $conn;
    $sql = "SELECT * FROM talleres";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    $talleres = [];
    while ($fila = mysqli_fetch_assoc($result)) {
        $talleres[] = $fila;
    }

    return $talleres;
}

function insertarTaller($nombre, $direccion, $descripcion, $telefono, $cupos_diarios) {
    global $conn;
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $direccion = mysqli_real_escape_string($conn, $direccion);
    $descripcion = mysqli_real_escape_string($conn, $descripcion);
    $telefono = mysqli_real_escape_string($conn, $telefono);
    $cupos_diarios = (int)$cupos_diarios;

    $sql = "INSERT INTO talleres (nombre, direccion, descripcion, telefono, cupos_diarios) 
            VALUES ('$nombre', '$direccion', '$descripcion', '$telefono', $cupos_diarios)";

    return mysqli_query($conn, $sql);
}

function validarTaller($nombre, $direccion, $descripcion, $telefono, $cupos_diarios) {
    if (empty($nombre) || empty($direccion) || empty($descripcion) || empty($cupos_diarios)) {
        return false;
    }

    if (!is_numeric($cupos_diarios) || $cupos_diarios <= 0) {
        return false;
    }

    if (!empty($telefono) && !preg_match('/^\d{7,15}$/', $telefono)) {
        return false;
    }

    return true;
}
?>
