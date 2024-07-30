<?php
include 'conexion.php';

//? crear usuario
function crearUsuario($nombre, $email, $password, $estado, $rol, $imagen) {
    global $conn;
    $hash_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO usuarios (nombre, email, contraseña, imagen, estado, rol) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $email, $hash_password, $imagen, $estado, $rol);
    return $stmt->execute();
}


//? actualizar perfil de usuario
function actualizarUsuario($id, $nombre, $email, $estado, $imagen) {
    global $conn;
    $sql = "UPDATE usuarios SET nombre = ?, email = ?, estado = ?, imagen = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $email, $estado, $imagen, $id);
    return $stmt->execute();
}



//? crear practica profesional
function crearOferta($titulo, $descripcion, $empresa, $salario, $ubicacion) {
    global $conn;
    $sql = "INSERT INTO ofertas (titulo, descripcion, empresa, salario, ubicacion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $titulo, $descripcion, $empresa, $salario, $ubicacion);
    return $stmt->execute();
}

//? Función para obtener una oferta por id
function obtenerOfertaPorId($id) {
    global $conn;
    $sql = "SELECT * FROM ofertas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

//?actualizar una oferta de empleo
function actualizarOferta($id, $titulo, $descripcion, $empresa, $salario, $ubicacion) {
    global $conn;
    $sql = "UPDATE ofertas SET titulo = ?, descripcion = ?, empresa = ?, salario = ?, ubicacion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $titulo, $descripcion, $empresa, $salario, $ubicacion, $id);
    return $stmt->execute();
}

//?eliminar una oferta de empleo
function eliminarOferta($id) {
    global $conn;
    $sql = "DELETE FROM ofertas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
