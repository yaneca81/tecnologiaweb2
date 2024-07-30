<?php
include '../config/config.php';

function obtenerEmpleosAdmin() {
    global $conn;
    $sql = "SELECT * FROM empleo";
    $result = $conn->query($sql);
    $empleos = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $empleos[] = $row;
        }
    }

    return $empleos;
}

function eliminarEmpleo($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM empleo WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function desactivarEmpleo($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE empleo SET estado = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function activarEmpleo($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE empleo SET estado = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function agregarEmpleo($titulo, $descripcion, $categoria, $fotoPath) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO empleo (titulo, descripcion, categoria, foto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $descripcion, $categoria, $fotoPath);
    return $stmt->execute();
}

?>
