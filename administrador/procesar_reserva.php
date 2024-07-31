<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/conexion.php'; 

    $id_cupo = $_POST['id_cupo'];
    $accion = $_POST['accion'];

    if ($accion === 'aceptar') {
        $sql = "UPDATE cupos SET estado = 'aceptado' WHERE id_cupo = ?";
    } elseif ($accion === 'eliminar') {
        $sql = "DELETE FROM cupos WHERE id_cupo = ?";
    } else {
        echo json_encode(['message' => 'Acción no válida']);
        exit;
    }

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $id_cupo);
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Acción realizada correctamente']);
        } else {
            echo json_encode(['message' => 'Error al ejecutar la acción']);
        }
        $stmt->close();
    } else {
        echo json_encode(['message' => 'Error en la preparación de la consulta']);
    }

    $conn->close();
} else {
    echo json_encode(['message' => 'Método de solicitud no válido']);
}
