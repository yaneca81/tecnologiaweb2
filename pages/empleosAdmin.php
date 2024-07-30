<?php
include '../includes/header_admin.php';
include '../logic/empleosAdminLogic.php';

$empleos = obtenerEmpleosAdmin();

if (isset($_GET['eliminar'])) {
    eliminarEmpleo($_GET['eliminar']);
    header('Location: empleosAdmin.php');
    exit();
}

if (isset($_GET['desactivar'])) {
    desactivarEmpleo($_GET['desactivar']);
    header('Location: empleosAdmin.php');
    exit();
}

if (isset($_GET['activar'])) {
    activarEmpleo($_GET['activar']);
    header('Location: empleosAdmin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Empleos</title>
    <link rel="stylesheet" href="../assets/css/empleosAdmin.css">
</head>
<body>
<main>
    <h2>Administrar Empleos</h2>
    <a href="agregarEmpleo.php" class="button agregar">Añadir Empleo</a>
    <div class="empleos-container">
        <?php if (count($empleos) > 0): ?>
            <?php foreach ($empleos as $empleo): ?>
                <div class="empleo <?php echo $empleo['estado'] ? 'activo' : 'desactivado'; ?>">
                    <img src="<?php echo htmlspecialchars($empleo['foto']); ?>" alt="Foto de empleo">
                    <div class="empleo-info">
                        <h3><?php echo htmlspecialchars($empleo['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($empleo['categoria']); ?></p>
                    </div>
                    <div class="empleo-acciones">
                        <a href="editarEmpleo.php?id=<?php echo $empleo['id']; ?>" class="button editar">Editar</a>
                        <?php if ($empleo['estado']): ?>
                            <a href="empleosAdmin.php?desactivar=<?php echo $empleo['id']; ?>" class="button desactivar">Desactivar</a>
                        <?php else: ?>
                            <a href="empleosAdmin.php?activar=<?php echo $empleo['id']; ?>" class="button activar">Activar</a>
                        <?php endif; ?>
                        <a href="empleosAdmin.php?eliminar=<?php echo $empleo['id']; ?>" class="button eliminar">Eliminar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay empleos disponibles.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>

<?php include '../includes/footer.php'; ?>
