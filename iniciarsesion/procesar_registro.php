<?php
include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Hash de la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

    // Insertar en la base de datos
    $query = "INSERT INTO usuarios (nombre, correo, telefono, contrasena, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss', $nombre, $correo, $telefono, $contrasena_hash, $tipo_usuario);

    if ($stmt->execute()) {
        // Redirigir al formulario de inicio de sesión con un mensaje de éxito
        header('Location: registro.php?success=true');
    } else {
        // Manejar errores y redirigir si es necesario
        echo "Error: " . $stmt->error;
    }
}
?>
