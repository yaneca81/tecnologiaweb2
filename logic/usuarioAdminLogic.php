<?php
include '../config/config.php';

function obtenerUsuariosAdmin() {
    global $conn;
    $sql = "SELECT * FROM usuario WHERE rol = 'admin'";
    $result = $conn->query($sql);
    $usuarios = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }

    return $usuarios;
}

function obtenerUsuariosEstudiantes() {
    global $conn;
    $sql = "SELECT * FROM usuario WHERE rol = 'estudiante'";
    $result = $conn->query($sql);
    $usuarios = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }

    return $usuarios;
}

function eliminarUsuario($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function agregarUsuarioAdmin($user, $password, $nombre, $apellido, $correo, $telefono, $direccion, $foto) {
    global $conn;
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO usuario (user, password, nombre, apellido, correo, telefono, direccion, foto, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'admin')");
    $stmt->bind_param("ssssssss", $user, $passwordHash, $nombre, $apellido, $correo, $telefono, $direccion, $foto);
    return $stmt->execute();
}

function obtenerUsuarioPorId($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function actualizarUsuarioAdmin($id, $nombre, $apellido, $correo, $telefono, $direccion, $foto) {
    global $conn;
    $stmt = $conn->prepare("UPDATE usuario SET nombre = ?, apellido = ?, correo = ?, telefono = ?, direccion = ?, foto = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $nombre, $apellido, $correo, $telefono, $direccion, $foto, $id);
    return $stmt->execute();
}
?>
