<?php
include '../config/config.php';

function obtenerMisPostulaciones($id_usuario) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT p.fecha, p.estado, e.titulo, e.foto, e.categoria
        FROM postulacion p
        JOIN empleo e ON p.id_empleo = e.id
        WHERE p.id_usuario = ?
        ORDER BY p.fecha DESC
    ");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $postulaciones = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $postulaciones[] = $row;
        }
    }

    return $postulaciones;
}
?>
