<?php
include '../includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit();
}

//? Obtener la información del usuario
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id='$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $nombre = $usuario['nombre'];
    $imagen = $usuario['imagen'];
} else {
    //? Manejar el caso en que el usuario no exista
    echo "Usuario no encontrado.";
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$tipo_usuario = isset($_GET['tipo_usuario']) ? $_GET['tipo_usuario'] : '';

if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    $sql_ofertas = "SELECT * FROM ofertas WHERE activa = 1 AND (titulo LIKE '%$search%' OR empresa LIKE '%$search%')";
    if ($tipo_usuario != '') {
        $sql_ofertas .= " AND categoria='$tipo_usuario'";
    }

    $result_ofertas = $conn->query($sql_ofertas);
    $ofertas = [];

    if ($result_ofertas->num_rows > 0) {
        while ($row = $result_ofertas->fetch_assoc()) {
            $oferta_id = $row['id'];
            $sql_postulacion = "SELECT * FROM postulaciones WHERE id_usuario='$usuario_id' AND id_oferta='$oferta_id'";
            $result_postulacion = $conn->query($sql_postulacion);

            if ($result_postulacion->num_rows > 0) {
                $row['postulado'] = true;
            } else {
                $row['postulado'] = false;
            }

            $ofertas[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($ofertas);
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard del Usuario</title>
    <link rel="stylesheet" href="../css/dashboard_usuario.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="../js/dashboard_usuario.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Anuncios de Empleo</div>
            <ul class="perfil">
                <li><a href="dashboard_usuario.php">Inicio</a></li>
                <li><a href="postulaciones.php">Mis Postulaciones</a></li>
                <li><a href="logout.php" id="logout-link">Cerrar Sesión</a></li>
                <li><a href="perfil.php"><img src="../imagenes/<?php echo htmlspecialchars($imagen); ?>" alt="Foto de Perfil"></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="dashboard">
            <h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?></h1>
            <div class="busqueda">
                <form method="get" id="searchForm" action="dashboard_usuario.php">
                    <input type="text" name="search" id="search" placeholder="Buscar por título, empresa o tipo" value="<?php echo htmlspecialchars($search); ?>">
                    <select name="tipo_usuario" id="tipo_usuario">
                        <option value="">Todos</option>
                        <option value="Estudiante" <?php if ($tipo_usuario == 'Estudiante') echo 'selected'; ?>>Estudiante</option>
                        <option value="Egresado" <?php if ($tipo_usuario == 'Egresado') echo 'selected'; ?>>Egresado</option>
                    </select>
                    <button type="submit">Buscar</button>
                </form>
            </div>

            <h1>Ofertas disponibles:</h1>
            <div class="ofertas" id="ofertas">
                <!-- Aquí se insertarán las ofertas mediante AJAX -->
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Anuncios de Empleo - Programación WEB II - Juan Carlos de León</p>
    </footer>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            fetchOfertas();
        });

        document.getElementById('tipo_usuario').addEventListener('change', function() {
            fetchOfertas();
        });

        function fetchOfertas() {
            const search = document.getElementById('search').value;
            const tipo_usuario = document.getElementById('tipo_usuario').value;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'dashboard_usuario.php?ajax=1&search=' + encodeURIComponent(search) + '&tipo_usuario=' + encodeURIComponent(tipo_usuario), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const ofertas = JSON.parse(xhr.responseText);
                    const ofertasContainer = document.getElementById('ofertas');
                    ofertasContainer.innerHTML = '';

                    if (ofertas.length > 0) {
                        ofertas.forEach(function(oferta) {
                            const ofertaElement = document.createElement('div');
                            ofertaElement.classList.add('oferta');
                            ofertaElement.innerHTML = `
                                <div class="oferta" onclick="window.location.href='detalle_oferta.php?id=${oferta.id}'">
                                    <img src="../imagenes/${oferta.imagen}" alt="Imagen de la Empresa">
                                    <div>
                                        <h2>${oferta.titulo}</h2>
                                        <p>${oferta.descripcion}</p>
                                        <p><strong>Categoría:</strong> ${oferta.categoria}</p>
                                        <p><strong>Empresa:</strong> ${oferta.empresa}</p>
                                        <p><strong>Contacto:</strong> ${oferta.email_contacto}</p>
                                        ${oferta.postulado ? '<button class="button-disabled" disabled>Postulado</button>' : '<button>Postularme</button>'}
                                    </div>
                                </div>
                            `;
                            ofertasContainer.appendChild(ofertaElement);
                        });
                    } else {
                        ofertasContainer.innerHTML = '<p>No hay ofertas de empleo registradas.</p>';
                    }
                }
            };
            xhr.send();
        }

        //? Cargar ofertas al cargar la página
        fetchOfertas();
    </script>
</body>
</html>
