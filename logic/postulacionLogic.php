<?php
include '../config/config.php';

function insertpostularse($posData) {
    global $conn;
    $fecha = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO postulacion (id_usuario, id_empleo, fecha, archivo, mensaje) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $posData['userid'], $posData['empleoid'], $fecha, $posData['archivo'], $posData['mensaje']);
    return $stmt->execute();
}
?>