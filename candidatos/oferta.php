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

// Verificar si se ha proporcionado un ID de oferta
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id_oferta = $_GET['id'];

// Obtener los detalles de la oferta de trabajo
$oferta = obtenerOfertaPorId($id_oferta);

if (!$oferta) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Oferta</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($oferta['titulo']); ?></h1>
    <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($oferta['descripcion'])); ?></p>
    <p><strong>Requisitos:</strong> <?php echo nl2br(htmlspecialchars($oferta['requisitos'])); ?></p>
    <p><strong>Salario:</strong> <?php echo htmlspecialchars($oferta['salario']); ?></p>

    <form action="agendar.php" method="post">
        <input type="hidden" name="id_oferta" value="<?php echo $oferta['id_oferta']; ?>">
        <button type="submit">Agendar Entrevista</button>
    </form>
</body>
</html>
