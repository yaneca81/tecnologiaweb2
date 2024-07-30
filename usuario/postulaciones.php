<?php
include '../includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit();
}

//? Obtener la información del usuario
$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = "SELECT * FROM usuarios WHERE id='$usuario_id'";
$result_usuario = $conn->query($sql_usuario);

if ($result_usuario->num_rows > 0) {
    $usuario = $result_usuario->fetch_assoc();
    $nombre = $usuario['nombre'];
    $imagen = $usuario['imagen'];
} else {
    //? Manejar el caso en que el usuario no exista
    echo "Usuario no encontrado.";
    exit();
}

//? Obtener las postulaciones del usuario
$sql_postulaciones = "SELECT p.*, o.titulo, o.empresa, o.imagen AS imagen_empresa, p.fecha_creacion
                      FROM postulaciones p 
                      JOIN ofertas o ON p.id_oferta = o.id 
                      WHERE p.id_usuario = '$usuario_id'";
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
    <title>Postulaciones del Practicante</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/postulaciones.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../node_modules/animate.css/animate.min.css">
    <script src="../js/postulaciones.js" defer></script>   
</head>
<body>
    <header>
        <nav>
            <div class="logo">Postulaciones del Practicante</div>
            <ul class="perfil">
                <li><a href="dashboard_usuario.php">Inicio</a></li>
                <li><a href="postulaciones.php">Postulaciones</a></li>
                <li><a href="logout.php" id="logout-link">Cerrar Sesión</a></li>
                <li><a href="perfil.php"><img src="../imagenes/<?php echo htmlspecialchars($imagen); ?>" alt="Foto de Perfil"></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="postulaciones animate__animated animate__zoomInDown">
            <h1>Mis Postulaciones</h1>
            <?php if (count($postulaciones) > 0): ?>
                <?php foreach ($postulaciones as $postulacion): ?>
                    <a href="detalle_oferta.php?id=<?php echo $postulacion['id_oferta']; ?>" class="postulacion">
                        <img src="../imagenes/<?php echo htmlspecialchars($postulacion['imagen_empresa']); ?>" alt="Imagen de la Empresa">
                        <div>
                            <h2><?php echo htmlspecialchars($postulacion['titulo']); ?></h2>
                            <p><strong>Empresa:</strong> <?php echo htmlspecialchars($postulacion['empresa']); ?></p>
                            <p><strong>Fecha de Postulación:</strong> <?php echo htmlspecialchars($postulacion['fecha_creacion']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No has realizado ninguna postulación.</p>
            <?php endif; ?>
        </div>
    </main>
    <br><br><br><br><br><br><br><br><br><br><br>
    <?php
        include("../footer.php");
     ?>
</body>
</html>
