<?php
include '../config/config.php';

function obtenerPostulacionesEnEspera() {
    global $conn;
    $sql = "SELECT postulacion.*, usuario.nombre, usuario.apellido, usuario.direccion, usuario.correo, usuario.telefono, usuario.foto, empleo.titulo 
            FROM postulacion 
            JOIN usuario ON postulacion.id_usuario = usuario.id 
            JOIN empleo ON postulacion.id_empleo = empleo.id 
            WHERE postulacion.estado = 'espera'";
    $result = $conn->query($sql);
    $postulaciones = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $postulaciones[] = $row;
        }
    }

    return $postulaciones;
}

function obtenerPostulacionPorId($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT postulacion.*, usuario.nombre, usuario.apellido, usuario.direccion, usuario.correo, usuario.telefono, usuario.foto, empleo.titulo 
                            FROM postulacion 
                            JOIN usuario ON postulacion.id_usuario = usuario.id 
                            JOIN empleo ON postulacion.id_empleo = empleo.id 
                            WHERE postulacion.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function actualizarEstadoPostulacion($id, $estado) {
    global $conn;
    $stmt = $conn->prepare("UPDATE postulacion SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $estado, $id);
    return $stmt->execute();
}
?>
