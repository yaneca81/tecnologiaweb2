<?php
session_start(); // Iniciar la sesión para manejar variables de sesión

// Incluir el archivo de funciones
include '../incluye/funciones.php';
include '../incluye/parciales/cabeceracandidato.php';

// Obtener el rol del usuario
$rol_usuario = isset($_SESSION['usuario_id']) ? obtenerRolUsuario($_SESSION['usuario_id']) : null;

// Verificar si el usuario está autenticado como candidato
if ($rol_usuario !== 'candidato') {
    header('Location: ../autentificacion/iniciar_sesion.php');
    exit();
}

$ofertas = obtenerOfertas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Candidato</title>
</head>
<body>
    <h1>Bienvenido, Candidato</h1>
    
    <?php if (!empty($ofertas)): ?>
        <div class="ofertas">
            <?php foreach ($ofertas as $oferta): ?>
                <div class="oferta">
                    <h2><?php echo htmlspecialchars($oferta['titulo']); ?></h2>
                    <p><?php echo htmlspecialchars($oferta['descripcion']); ?></p>
                    <a href="oferta.php?id=<?php echo $oferta['id_oferta']; ?>">Ver más detalles</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay ofertas disponibles en este momento.</p>
    <?php endif; ?>

</body>
</html>
