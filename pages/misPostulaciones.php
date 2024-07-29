<?php
include '../config/config.php';
include '../includes/header.php';
include '../logic/MisPostulacionesLogic.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_COOKIE['user_id'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_COOKIE['user_id'];
$postulaciones = obtenerMisPostulaciones($id_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Postulaciones</title>
    <link rel="stylesheet" href="../assets/css/misPostulaciones.css">
</head>
<body>
<main>
    <h2>Mis Postulaciones</h2>
    <div class="postulaciones-container">
        <?php if (count($postulaciones) > 0): ?>
            <?php foreach ($postulaciones as $postulacion): ?>
                <div class='postulacion'>
                    <img src='<?php echo $postulacion['foto']; ?>' alt='<?php echo $postulacion['titulo']; ?>'>
                    <div class='postulacion-info'>
                        <h3><?php echo $postulacion['titulo']; ?></h3>
                        <p>Categoría: <?php echo $postulacion['categoria']; ?></p>
                        <p>Fecha de postulación: <?php echo $postulacion['fecha']; ?></p>
                        <p class='estado <?php echo strtolower($postulacion['estado']); ?>'>Estado: <?php echo $postulacion['estado']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No has realizado ninguna postulación.</p>
        <?php endif; ?>
    </div>
</main>

</body>
</html>

<?php include '../includes/footer.php'; ?>
