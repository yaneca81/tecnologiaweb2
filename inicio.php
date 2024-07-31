<?php
include 'includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: iniciarsesion/login.php');
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
    <link rel="stylesheet" href="estilos/carusel.css">
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
                    <li><a href="iniciarsesion/cerrar_sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>
        <section class="descripcion">
            <h2>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h2>
            <p>En TURBOGARAGEMONKEY, nos dedicamos a brindar servicios de mantenimiento vehicular de la más alta calidad. Contamos con un equipo de profesionales altamente capacitados para garantizar que tu vehículo siempre esté en óptimas condiciones.</p>
        </section>
        
        <section class="repuestos">
            <h2>Repuestos Disponibles</h2>
            <div class="repuesto-card">
                <img src="https://img.freepik.com/fotos-premium/filtro-aire-cuadrado-automovil-sobre-superficie-blanca_41929-2433.jpg" alt="Repuesto 1">
                <h3>Repuesto 1</h3>
                <p>Descripción breve del repuesto 1.</p>
            </div>
            <div class="repuesto-card">
                <img src="https://cdn.club-magazin.autodoc.de/uploads/sites/11/2022/03/piston.jpg" alt="Repuesto 2">
                <h3>Repuesto 2</h3>
                <p>Descripción breve del repuesto 2.</p>
            </div>
            <div class="repuesto-card">
                <img src="https://img.freepik.com/fotos-premium/pastillas-freno-pastillas-freno-coche-sobre-fondo-blanco-juego-pastillas-freno-rojas-piezas-repuesto-coche-imagen-texturizada_314149-5575.jpg" alt="Repuesto 3">
                <h3>Repuesto 3</h3>
                <p>Descripción breve del repuesto 3.</p>
            </div>
            <div class="repuesto-card">
                <img src="https://resources.apymsa.com.mx/imagenes/FotosSpeed/0107505/01075052a.jpg" alt="Repuesto 4">
                <h3>Repuesto 4</h3>
                <p>Descripción breve del repuesto 4.</p>
            </div>
            <div class="repuesto-card">
                <img src="https://m.media-amazon.com/images/I/61HwcW9W1eL.jpg" alt="Repuesto 5">
                <h3>Repuesto 5</h3>
                <p>Descripción breve del repuesto 5.</p>
            </div>
            <div class="repuesto-card">
                <img src="https://ae01.alicdn.com/kf/Sc03431b9f65f4489bbd3025eecc29c15c.jpg_640x640Q90.jpg_.webp" alt="Repuesto 6">
                <h3>Repuesto 6</h3>
                <p>Descripción breve del repuesto 6.</p>
            </div>
            <div class="repuesto-card">
                <img src="https://http2.mlstatic.com/D_NQ_NP_869066-MLC75442117338_042024-O.webp" alt="Repuesto 7">
                <h3>Repuesto 7</h3>
                <p>Descripción breve del repuesto 7.</p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 TURBOGARAGEMONKEY. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
