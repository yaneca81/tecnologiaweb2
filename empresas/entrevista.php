<?php
session_start(); // Iniciar la sesión para manejar variables de sesión

// Incluir el archivo de funciones
include '../incluye/funciones.php';
include_once '../incluye/parciales/cabeceraempresa.php';

// Obtener el rol del usuario
$rol_usuario = isset($_SESSION['usuario_id']) ? obtenerRolUsuario($_SESSION['usuario_id']) : null;

// Verificar si el usuario está autenticado como empresa
if ($rol_usuario !== 'empresa') {
    header('Location: ../autentificacion/iniciar_sesion.php');
    exit();
}

// Obtener el id_usuario desde la sesión
$id_usuario = $_SESSION['usuario_id'];

// Obtener el id_empresa correspondiente al id_usuario
$id_empresa = obtenerIdEmpresa($id_usuario);

// Verificar que el id_empresa es válido
if (!$id_empresa) {
    echo "Error: No se encontró una empresa para el usuario.";
    exit();
}

// Obtener todas las entrevistas para la empresa
$sql = "SELECT e.id_entrevista, o.titulo, c.nombre, c.apellido, e.fecha, e.estado
        FROM entrevistas e
        JOIN ofertas_trabajo o ON e.id_oferta = o.id_oferta
        JOIN candidatos c ON e.id_candidato = c.id_candidato
        WHERE o.id_empresa = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id_empresa);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$entrevistas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $entrevistas[] = $row;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entrevistas - Empresa</title>
</head>
<body>
    <h1>Entrevistas Programadas</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID Entrevista</th>
                <th>Título Oferta</th>
                <th>Nombre Candidato</th>
                <th>Apellido Candidato</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entrevistas as $entrevista): ?>
                <tr>
                    <td><?php echo htmlspecialchars($entrevista['id_entrevista']); ?></td>
                    <td><?php echo htmlspecialchars($entrevista['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($entrevista['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($entrevista['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($entrevista['estado']); ?></td>
                    <td>
                        <form action="cambiar_estado_entrevista.php" method="POST">
                            <input type="hidden" name="id_entrevista" value="<?php echo htmlspecialchars($entrevista['id_entrevista']); ?>">
                            <select name="estado" required>
                                <option value="">Seleccionar Estado</option>
                                <option value="pendiente" <?php echo $entrevista['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="confirmada" <?php echo $entrevista['estado'] === 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                                <option value="rechazada" <?php echo $entrevista['estado'] === 'rechazada' ? 'selected' : ''; ?>>Rechazada</option>
                            </select>
                            <button type="submit">Actualizar Estado</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
