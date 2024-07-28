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
