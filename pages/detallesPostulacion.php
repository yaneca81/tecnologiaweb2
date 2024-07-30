<?php
include '../includes/header_admin.php';
include '../logic/postulacionAdminLogic.php';

if (!isset($_GET['id'])) {
    header('Location: postulacionAdmin.php');
    exit();
}

$postulacion = obtenerPostulacionPorId($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = $_POST['estado'];
    if (actualizarEstadoPostulacion($_GET['id'], $estado)) {
        header('Location: postulacionAdmin.php');
        exit();
    } else {
        $error = "Error al actualizar el estado de la postulación.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Postulación</title>
    <link rel="stylesheet" href="../assets/css/detallesPostulacion.css">
</head>
<body>
<main>
    <h2>Detalles de Postulación</h2>
    <?php if ($postulacion): ?>
        <div class="postulacion-detalles">
            <img src="<?php echo htmlspecialchars($postulacion['foto']); ?>" alt="Foto del postulante">
            <div class="postulacion-info">
                <h3><?php echo htmlspecialchars($postulacion['titulo']); ?></h3>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($postulacion['nombre']) . ' ' . htmlspecialchars($postulacion['apellido']); ?></p>
                <p><strong>Correo:</strong> <?php echo htmlspecialchars($postulacion['correo']); ?></p>
                <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($postulacion['telefono']); ?></p>
                <p><strong>Dirección:</strong> <?php echo htmlspecialchars($postulacion['direccion']); ?></p>
                <p><strong>Mensaje:</strong> <?php echo htmlspecialchars($postulacion['mensaje']); ?></p>
                <p><strong>Currículum:</strong> <a href="<?php echo htmlspecialchars($postulacion['archivo']); ?>" target="_blank">Ver PDF</a></p>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="estado" value="aceptado">
                <button type="submit" class="button aceptar">Aceptar</button>
            </form>
            <form method="POST" action="">
                <input type="hidden" name="estado" value="rechazado">
                <button type="submit" class="button rechazar">Rechazar</button>
            </form>
            <?php if (isset($error)): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
            <a href="postulacionAdmin.php" class="button volver">Volver</a>
        </div>
    <?php else: ?>
        <p>Postulación no encontrada.</p>
    <?php endif; ?>
</main>
</body>
</html>

<?php include '../includes/footer.php'; ?>
