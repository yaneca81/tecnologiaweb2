<?php
include '../config/config.php';

function userExists($user) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM usuario WHERE user = ?");
    $sql->bind_param("s", $user);
    $sql->execute();
    $result = $sql->get_result();  
    return $result->num_rows > 0;
}

function emailExists($email){
    global $conn;
    $sql = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    return $result->num_rows > 0;
}

function insertUser($userData) {
    global $conn;
    $sql = $conn->prepare("INSERT INTO usuario (user, password, nombre, apellido, correo, telefono, direccion, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $passwordHash = password_hash($userData['password'], PASSWORD_BCRYPT);
    $sql->bind_param("ssssssss", $userData['user'], $passwordHash, $userData['nombre'], $userData['apellido'], $userData['correo'], $userData['telefono'], $userData['direccion'], $userData['foto']);
    return $sql->execute();
}
?>