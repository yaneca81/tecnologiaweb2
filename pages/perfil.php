<?php
include '../config/config.php';
//include '../includes/header.php';
include '../logic/auth.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_COOKIE['user_id'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_COOKIE['user_id'];
$usuario = obtenerUsuario($id_usuario);
($usuario['rol'] == 'estudiante')? include '../includes/header.php' : include '../includes/header_admin.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="../assets/css/perfil.css">
</head>
<body>
<main>
    <h2>Perfil del Usuario</h2>
    <div class="perfil-container">
        <img src="<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto de perfil" class="foto-perfil">
        <div class="perfil-info">
            <p><strong>Usuario:</strong> <?php echo htmlspecialchars($usuario['user']); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
            <p><strong>Apellido:</strong> <?php echo htmlspecialchars($usuario['apellido']); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuario['correo']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['telefono']); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($usuario['direccion']); ?></p>
        </div>
        <a href="editarPerfil.php" class="button">Editar Perfil</a>
    </div>
</main>
</body>
</html>

<?php include '../includes/footer.php'; ?>
