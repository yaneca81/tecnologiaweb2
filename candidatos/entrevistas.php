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

// Obtener las entrevistas del candidato
$id_usuario = $_SESSION['usuario_id'];
$entrevistas = obtenerEntrevistasCandidato($id_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Entrevistas</title>
</head>
<body>
    <h1>Mis Entrevistas</h1>
    
    <?php if (!empty($entrevistas)): ?>
        <table>
            <thead>
                <tr>
                    <th>Oferta</th>
                    <th>Empresa</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entrevistas as $entrevista): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entrevista['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($entrevista['nombre_empresa']); ?></td>
                        <td><?php echo htmlspecialchars($entrevista['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($entrevista['estado']); ?></td>
                        <td>
                            <form action="cambiar_estado_entrevista.php" method="post" onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta entrevista?');">
                                <input type="hidden" name="id_entrevista" value="<?php echo $entrevista['id_entrevista']; ?>">
                                <input type="hidden" name="accion" value="cancelar">
                                <button type="submit">Cancelar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes entrevistas agendadas.</p>
    <?php endif; ?>
</body>
</html>
