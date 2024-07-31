<?php
include 'includes/conexion.php'; 

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $telefono = $_POST['telefono'];
    $cupos_diarios = $_POST['cupos_diarios'];

    $sql = "INSERT INTO talleres (nombre, direccion, descripcion, telefono, cupos_diarios) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $direccion, $descripcion, $telefono, $cupos_diarios);

    if ($stmt->execute()) {
        $response['success'] = true;
    }

    $stmt->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);

