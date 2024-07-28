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
?>
