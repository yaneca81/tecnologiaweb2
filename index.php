<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$usuario = $_SESSION['usuario'];
$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Plataforma de Mantenimiento Vehicular</title>
    <link rel="stylesheet" href="estilos/style.css">
</head>
<body>
    <main>
        <header>
            <div class="logo">
                <img src="https://ih1.redbubble.net/image.3446552821.5947/flat,750x,075,f-pad,750x1000,f8f8f8.jpg" alt="Logo del Taller" width="100">
                <h1>TURBOGARAGEMONKEY</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="inicio.php">Inicio</a></li>
                    <li><a href="cupos.php">Reservar</a></li>
                    <li><a href="taller.php">Talleres</a></li>
                    <li><a href="listar.php">Lista de Reservas</a></li>
                    <li><a href="iniciarsesion\cerrar_sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>
    </main>
    <footer>
        <p>&copy; 2024 TURBOGARAGEMONKEY. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
