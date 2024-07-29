<?php
include '../includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../usuario/login.php');
    exit();
}

$admin_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id='$admin_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    $nombre = $admin['nombre'];
} else {
    echo "Administrador no encontrado.";
    exit();
}

$sql_ofertas = "SELECT o.*, (SELECT COUNT(*) FROM postulaciones p WHERE p.id_oferta = o.id) AS total_postulaciones 
                FROM ofertas o";
$result_ofertas = $conn->query($sql_ofertas);

$ofertas = [];
if ($result_ofertas->num_rows > 0) {
    while ($row = $result_ofertas->fetch_assoc()) {
        $ofertas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/dashboard_administrador.css">


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
        <section class="contenido-principal">
            <h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?></h1>
            <p>Desde aquí puedes gestionar las prácticas profesionales.</p>
            <div class="acciones">
                <a href="crear_oferta.php" class="btn">Crear Nueva Oferta</a>
                <a href="ver_ofertas.php" class="btn">Gestionar Ofertas Existentes</a>
            </div>
        </section>
        <section class="contenido-ofertas">
            <?php if (count($ofertas) > 0): ?>
                <?php foreach ($ofertas as $oferta): ?>
                    <div class="oferta-card" onclick="window.location.href='postulaciones.php?id=<?php echo $oferta['id']; ?>'">
                        <img src="../imagenes/<?php echo htmlspecialchars($oferta['imagen']); ?>" alt="Logo de Empresa">
                        <p><strong><?php echo htmlspecialchars($oferta['titulo']); ?></strong></p>
                        <p><?php echo htmlspecialchars($oferta['empresa']); ?></p>
                        <p><strong>Postulaciones:</strong> <?php echo $oferta['total_postulaciones']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay ofertas de prácticas registradas.</p>
            <?php endif; ?>
        </section>
    </main>
    <?php
        include("../footer.php");
     ?>
    
</body>
</html>
