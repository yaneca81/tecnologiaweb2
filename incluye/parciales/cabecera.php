<?php
session_start();
include 'incluye/funciones.php'; // Asegúrate de incluir las funciones

// Obtener el tipo de usuario si está autenticado
$rol_usuario = isset($_SESSION['usuario_id']) ? obtenerRolUsuario($_SESSION['usuario_id']) : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <link rel="stylesheet" href="src/css/estilo.css">
    <!-- Aquí puedes agregar otros enlaces a CSS o JS -->
</head>
<body>
    <header>
        <nav>
            <ul>
               
                <!-- Opciones para usuarios no autenticados -->
                <li><a href="autentificacion/iniciar_sesion.php">Iniciar Sesión</a></li>
                <li><a href="autentificacion/registro.php">Registrarse</a></li>
               
            </ul>
        </nav>
    </header>
    <!-- Aquí puedes agregar contenido adicional del encabezado -->
