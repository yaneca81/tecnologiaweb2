<?php
include '../includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$oferta_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql_oferta = "SELECT * FROM ofertas WHERE id = $oferta_id";
$result_oferta = $conn->query($sql_oferta);

if ($result_oferta->num_rows > 0) {
    $oferta = $result_oferta->fetch_assoc();
} else {
    echo "Oferta no encontrada.";
    exit();
}

$empresa = $oferta['empresa'];
$sql_otras_ofertas = "SELECT * FROM ofertas WHERE empresa = '$empresa' AND id != $oferta_id AND activa = 1";
$result_otras_ofertas = $conn->query($sql_otras_ofertas);

$otras_ofertas = [];
if ($result_otras_ofertas->num_rows > 0) {
    while ($row = $result_otras_ofertas->fetch_assoc()) {
        $otras_ofertas[] = $row;
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Oferta</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/detalle_oferta.css">
    <script src="../js/detalle_oferta.js" defer></script>   
</head>
<body>
    <header>
        <nav>
            <div class="logo">Detalles de la Oferta </div>
            <ul>
                <li><a href="dashboard_usuario.php">Inicio</a></li>
                <li><a href="postulaciones.php">Mis Postulaciones</a></li>
                <li><a href="logout.php" id="logout-link">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="detalles-oferta">
            <h1><?php echo htmlspecialchars($oferta['titulo']); ?></h1>
            <img src="../imagenes/<?php echo htmlspecialchars($oferta['imagen']); ?>" alt="Imagen de la Empresa">
            <p><?php echo htmlspecialchars($oferta['descripcion']); ?></p>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($oferta['categoria']); ?></p>
            <p><strong>Empresa:</strong> <?php echo htmlspecialchars($oferta['empresa']); ?></p>
            <p><strong>Contacto:</strong> <?php echo htmlspecialchars($oferta['email_contacto']); ?></p>
            <?php if ($ya_postulado): ?>
                <p><strong>Ya postulado</strong></p>
                <button id="eliminarPostulacion" data-id="<?php echo $oferta['id']; ?>">Eliminar Postulación</button>
            <?php else: ?>
                <button id="postularme" data-id="<?php echo $oferta['id']; ?>">Postularme</button>
            <?php endif; ?>
        </div>

       

        <!-- Modal de confirmación -->
        <div id="modalConfirm" class="modal">
            <div class="modal-content">
                <div class="modal-header" id="modalHeader"></div>
                <div class="modal-buttons">
                    <button class="confirm" id="modalConfirmBtn">Confirmar</button>
                    <button class="cancel" id="modalCancelBtn">Cancelar</button>
                </div>
            </div>
        </div>
    </main>
    
     <?php
        include("../footer.php")
     ?>
</body>
</html>