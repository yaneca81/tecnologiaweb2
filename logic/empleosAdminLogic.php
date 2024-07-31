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

function agregarEmpleo($titulo, $descripcion, $categoria, $tipo, $fotoPath) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO empleo (titulo, descripcion, categoria, horario, foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $titulo, $descripcion, $categoria, $tipo, $fotoPath);
    return $stmt->execute();
}

function obtenerEmpleoPorId($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM empleo WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function actualizarEmpleo($id, $titulo, $descripcion, $categoria, $tipo, $fotoPath) {
    global $conn;
    $stmt = $conn->prepare("UPDATE empleo SET titulo = ?, descripcion = ?, categoria = ?, horario = ?, foto = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $titulo, $descripcion, $categoria, $tipo, $fotoPath, $id);
    return $stmt->execute();
}
?>
