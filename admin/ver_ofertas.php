<?php
include '../includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Obtener todas las ofertas de empleo con filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

$sql = "SELECT * FROM ofertas WHERE (titulo LIKE '%$search%' OR empresa LIKE '%$search%')";

if ($categoria != '') {
    $sql .= " AND categoria='$categoria'";
}

if ($estado !== '') {
    $sql .= " AND activa=$estado";
}

$result = $conn->query($sql);

$ofertas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ofertas[] = $row;
    }
}

// Manejar la habilitación/deshabilitación de ofertas
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['toggle_id'])) {
    $oferta_id = $_POST['toggle_id'];
    $estado_actual = $_POST['estado_actual'];
    $nuevo_estado = $estado_actual ? 0 : 1;
    
    $sql_toggle = "UPDATE ofertas SET activa=$nuevo_estado WHERE id=$oferta_id";
    if ($conn->query($sql_toggle) === TRUE) {
        header('Location: ver_ofertas.php');
        exit();
    } else {
        echo "Error al actualizar el estado de la oferta.";
    }
}

// Manejar la eliminación de ofertas
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $oferta_id = $_POST['delete_id'];
    
    $sql_delete = "DELETE FROM ofertas WHERE id=$oferta_id";
    if ($conn->query($sql_delete) === TRUE) {
        header('Location: ver_ofertas.php');
        exit();
    } else {
        echo "Error al eliminar la oferta.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Ofertas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/ver_ofertas_admin.css">
    <link rel="stylesheet" href="../node_modules/animate.css/animate.min.css">

    <script>
        function confirmarEliminacion(oferta_id) {
            if (confirm('¿Está seguro que desea eliminar esta oferta?')) {
                document.getElementById('delete-form-' + oferta_id).submit();
            }
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Panel de Administrador</div>
            <ul>
                <li><a href="dashboard_admin.php">Inicio</a></li>
                <li><a href="crear_oferta.php">Crear Oferta</a></li>
                <li><a href="ver_ofertas.php">Ver Ofertas</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="contenedor-principal animate__animated animate__bounceInDown">
            <section class="filtros" >
                <form method="get" action="ver_ofertas.php">
                    <input type="text" name="search" placeholder="Buscar por estudiante o egresado" value="<?php echo htmlspecialchars($search); ?>">
                    <select name="categoria">
                        <option value="">Todas las Categorías</option>
                        <option value="Estudiante" <?php if ($categoria == 'Estudiante') echo 'selected'; ?>>Estudiante</option>
                        <option value="Egresado" <?php if ($categoria == 'Egresado') echo 'selected'; ?>>Egresado</option>
                    </select>
                    <select name="estado">
                        <option value="">Todos los Estados</option>
                        <option value="1" <?php if ($estado === '1') echo 'selected'; ?>>Habilitado</option>
                        <option value="0" <?php if ($estado === '0') echo 'selected'; ?>>Deshabilitado</option>
                    </select>
                    <button type="submit" class="btn">Filtrar</button>
                </form>
            </section>
            <h1>Ofertas para los practicantes</h1>
            <section class="ofertas-container">
                <?php if (count($ofertas) > 0): ?>
                    <?php foreach ($ofertas as $oferta): ?>
                        <div class="oferta animate__animated animate__bounceInDown">
                            <h2><?php echo htmlspecialchars($oferta['titulo']); ?></h2>
                            <p><?php echo htmlspecialchars($oferta['descripcion']); ?></p>
                            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($oferta['categoria']); ?></p>
                            <p><strong>Empresa:</strong> <?php echo htmlspecialchars($oferta['empresa']); ?></p>
                            <p><strong>Contacto:</strong> <?php echo htmlspecialchars($oferta['email_contacto']); ?></p>
                            <div class="botones">
                                <form method="post" action="ver_ofertas.php" style="display:inline;">
                                    <input type="hidden" name="toggle_id" value="<?php echo $oferta['id']; ?>">
                                    <input type="hidden" name="estado_actual" value="<?php echo $oferta['activa']; ?>">
                                    <button type="submit" class="btn <?php echo $oferta['activa'] ? 'btn-activo' : 'btn-inactivo'; ?>"><?php echo $oferta['activa'] ? 'Deshabilitar' : 'Habilitar'; ?></button>
                                </form>
                                <button style=" margin-right:5px;"><a href="editar_oferta.php?id=<?php echo $oferta['id']; ?>" class="btn-activo" style="text-decoration: none; color: black;">Editar</a></button>
                                <form id="delete-form-<?php echo $oferta['id']; ?>" method="post" action="ver_ofertas.php" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $oferta['id']; ?>">
                                    <button type="button" class="btn btn-delete" onclick="confirmarEliminacion(<?php echo $oferta['id']; ?>)">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay ofertas de empleo registradas.</p>
                <?php endif; ?>
            </section>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Anuncios de Empleo. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
