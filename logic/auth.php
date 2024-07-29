<?php
include '../config/config.php';

function verifyCredentials($usernameOrEmail, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE user = ? OR correo = ?");
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}

function emailExists($correo, $id_usuario) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE correo = ? AND id != ?");
    $stmt->bind_param("si", $correo, $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function actualizarUsuario($id_usuario, $nombre, $apellido, $correo, $telefono, $direccion, $foto) {
    global $conn;
    $stmt = $conn->prepare("UPDATE usuario SET nombre = ?, apellido = ?, correo = ?, telefono = ?, direccion = ?, foto = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $nombre, $apellido, $correo, $telefono, $direccion, $foto, $id_usuario);
    return $stmt->execute();
}

function obtenerUsuario($id_usuario) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
?>
