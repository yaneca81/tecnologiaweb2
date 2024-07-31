<?php
include 'includes/conexion.php'; // Asegúrate de que la ruta es correcta
require_once 'funcion.php'; // Incluye la función solo una vez

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    if (verificarLogin($correo, $contrasena, $conn)) {
        // Redirigir al archivo index.php
        header('Location: ../index.php'); 
        exit();
    } else {
        header('Location: login.php?error=credenciales_invalidas');
        exit();
    }
}
?>
