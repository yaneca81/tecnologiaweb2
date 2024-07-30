<?php
include '../includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../usuario/login.php');
    exit();
}

$oferta_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql_oferta = "SELECT * FROM ofertas WHERE id = $oferta_id";
$result_oferta = $conn->query($sql_oferta);

if ($result_oferta->num_rows > 0) {
    $oferta = $result_oferta->fetch_assoc();
} else {
    echo "Oferta no encontrada.";
    exit();
}

$sql_postulaciones = "SELECT p.*, u.nombre, u.email, u.imagen 
                      FROM postulaciones p 
                      JOIN usuarios u ON p.id_usuario = u.id 
                      WHERE p.id_oferta = $oferta_id";
$result_postulaciones = $conn->query($sql_postulaciones);

$postulaciones = [];
if ($result_postulaciones->num_rows > 0) {
    while ($row = $result_postulaciones->fetch_assoc()) {
        $postulaciones[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Oferta de Empleo</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/postulacion_admin.css">
    <link rel="stylesheet" href="../node_modules/animate.css/animate.min.css">

</head>
<body>
    <header>
        <nav>
            <div class="logo">Panel de Administrador</div>
            <ul>
                <li><a href="dashboard_admin.php">Inicio</a></li>
                <li><a href="crear_oferta.php">Crear Oferta</a></li>
                <li><a href="ver_ofertas.php">Ver Ofertas</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="detalles-oferta  animate__animated animate__backInLeft">
            <h1><?php echo htmlspecialchars($oferta['titulo']); ?></h1>
            <img src="../imagenes/<?php echo htmlspecialchars($oferta['imagen']); ?>" alt="Logo de Empresa">
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($oferta['descripcion']); ?></p>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($oferta['categoria']); ?></p>
            <p><strong>Empresa:</strong> <?php echo htmlspecialchars($oferta['empresa']); ?></p>
            <p><strong>Correo de Contacto:</strong> <?php echo htmlspecialchars($oferta['email_contacto']); ?></p>
            <a href="editar_oferta.php?id=<?php echo $oferta_id; ?>" class="btn">Editar Oferta</a>
        </div>
        <div class="postulaciones">
            <h2>Postulaciones</h2>
            <?php if (count($postulaciones) > 0): ?>
                <?php foreach ($postulaciones as $postulacion): ?>
                    <div class="postulacion">
                        <img src="../imagenes/<?php echo htmlspecialchars($postulacion['imagen']); ?>" alt="Foto de Perfil">
                        <div>
                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($postulacion['nombre']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($postulacion['email']); ?></p>
                           
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay postulaciones para esta oferta.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Anuncios de Empleo. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
