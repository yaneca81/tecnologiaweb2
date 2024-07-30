<?php
include '../includes/header_admin.php';
include '../logic/usuarioAdminLogic.php';

$usuariosAdmin = obtenerUsuariosAdmin();
$usuariosEstudiantes = obtenerUsuariosEstudiantes();

if (isset($_GET['eliminar'])) {
    eliminarUsuario($_GET['eliminar']);
    header('Location: usuarioAdmin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="../assets/css/usuarioAdmin.css">
    <script src="../assets/js/usuarioAdmin.js" defer></script>
</head>
<body>
<main>
    <h2>Administrar Usuarios</h2>
    <a href="agregarUsuarioAdmin.php" class="button agregar">Añadir Usuario Admin</a>
    <div class="usuarios-container">
        <div class="usuarios-admin">
            <h3>Usuarios Administradores</h3>
            <?php if (count($usuariosAdmin) > 0): ?>
                <?php foreach ($usuariosAdmin as $usuario): ?>
                    <div class="usuario">
                        <img src="<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto de usuario">
                        <div class="usuario-info">
                            <h4><?php echo htmlspecialchars($usuario['user']); ?></h4>
                            <p><?php echo htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellido']); ?></p>
                            <p><?php echo htmlspecialchars($usuario['correo']); ?></p>
                        </div>
                        <div class="usuario-acciones">
                            <a href="editarPerfil.php?id=<?php echo $usuario['id']; ?>" class="button editar">Editar</a>
                            <a href="usuarioAdmin.php?eliminar=<?php echo $usuario['id']; ?>" class="button eliminar">Eliminar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay usuarios administradores disponibles.</p>
            <?php endif; ?>
        </div>
        
        <div class="usuarios-estudiantes">
            <h3>Usuarios Estudiantes</h3>
            <?php if (count($usuariosEstudiantes) > 0): ?>
                <?php foreach ($usuariosEstudiantes as $usuario): ?>
                    <div class="usuario">
                        <img src="<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto de usuario">
                        <div class="usuario-info">
                            <h4><?php echo htmlspecialchars($usuario['user']); ?></h4>
                            <p><?php echo htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellido']); ?></p>
                            <p><?php echo htmlspecialchars($usuario['correo']); ?></p>
                        </div>
                        <div class="usuario-acciones">
                            <button class="button eliminar" onclick="confirmarEliminacion(<?php echo $usuario['id']; ?>)">Eliminar</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay usuarios estudiantes disponibles.</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>¿Está seguro de que desea eliminar este usuario?</p>
            <button id="confirmYes" class="button confirmar">Sí</button>
            <button id="confirmNo" class="button cancelar">No</button>
        </div>
    </div>

</main>
</body>
</html>

<?php include '../includes/footer.php'; ?>
