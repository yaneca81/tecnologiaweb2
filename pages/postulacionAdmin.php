<?php
include '../includes/header_admin.php';
include '../logic/postulacionAdminLogic.php';

$postulaciones = obtenerPostulacionesEnEspera();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Postulaciones</title>
    <link rel="stylesheet" href="../assets/css/postulacionAdmin.css">
</head>
<body>
    <main>
        <h2>Administrar Postulaciones</h2>
        <div class="postulaciones-container">
            <?php if (count($postulaciones) > 0): ?>
                <?php foreach ($postulaciones as $postulacion): ?>
                    <div class="postulacion">
                        <img src="<?php echo htmlspecialchars($postulacion['foto']); ?>" alt="Foto del postulante">
                        <div class="postulacion-info">
                        <h3><?php echo htmlspecialchars($postulacion['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($postulacion['nombre']) . ' ' . htmlspecialchars($postulacion['apellido']); ?></p>
                        <p><?php echo htmlspecialchars($postulacion['mensaje']); ?></p>
                    </div>
                    <div class="postulacion-acciones">
                        <a href="detallesPostulacion.php?id=<?php echo $postulacion['id']; ?>" class="button examinar">Examinar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay postulaciones en espera.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>

<?php include '../includes/footer.php'; ?>
