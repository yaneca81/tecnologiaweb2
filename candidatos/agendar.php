<?php
session_start(); // Iniciar la sesión para manejar variables de sesión

// Incluir el archivo de funciones
include '../incluye/funciones.php';

// Obtener el rol del usuario
$rol_usuario = isset($_SESSION['usuario_id']) ? obtenerRolUsuario($_SESSION['usuario_id']) : null;

// Verificar si el usuario está autenticado como candidato
if ($rol_usuario !== 'candidato') {
    header('Location: ../autentificacion/iniciar_sesion.php');
    exit();
}

// Obtener el id_usuario desde la sesión
$id_usuario = $_SESSION['usuario_id'];

// Obtener el id_candidato correspondiente al id_usuario
$id_candidato = obtenerIdCandidato($id_usuario);

// Verificar que el id_candidato es válido
if (!$id_candidato) {
    echo "Error: No se encontró un candidato para el usuario.";
    exit();
}

// Verificar que se ha enviado un id_oferta
if (!isset($_POST['id_oferta'])) {
    echo "Error: No se ha proporcionado una oferta de trabajo.";
    exit();
}

$id_oferta = $_POST['id_oferta'];
$fecha = date('Y-m-d'); // Asignar la fecha actual para la entrevista

// Verificar si ya hay una entrevista pendiente para esta oferta
$sql = "SELECT * FROM entrevistas WHERE id_oferta = ? AND id_candidato = ? AND estado = 'pendiente'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $id_oferta, $id_candidato);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Ya existe una entrevista pendiente para esta oferta
    $mensaje = "Ya tienes una entrevista pendiente para esta oferta.";
} else {
    // Agregar la entrevista a la base de datos
    $sql = "INSERT INTO entrevistas (id_oferta, id_candidato, fecha, estado) VALUES (?, ?, ?, 'pendiente')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iis', $id_oferta, $id_candidato, $fecha);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $mensaje = "Entrevista agendada con éxito.";
    } else {
        $mensaje = "Error al agendar la entrevista: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn); // Cerrar la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Entrevista</title>
    <style>
        .mensaje {
            position: fixed;
            top: 10%;
            right: 10%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }
        .mensaje.error {
            background-color: #f44336;
        }
        .mensaje.show {
            display: block;
        }
    </style>
    <script>
        function mostrarMensaje(mensaje, tipo) {
            var mensajeDiv = document.getElementById('mensaje');
            mensajeDiv.className = 'mensaje ' + tipo + ' show';
            mensajeDiv.innerText = mensaje;
            setTimeout(function() {
                mensajeDiv.classList.remove('show');
                window.location.href = 'index.php'; // Redirigir a la página principal de candidatos
            }, 3000); // Mostrar el mensaje por 3 segundos
        }
    </script>
</head>
<body>
    <div id="mensaje" class="mensaje"></div>
    <script>
        var mensaje = <?php echo json_encode($mensaje); ?>;
        var tipo = <?php echo json_encode(isset($mensaje) && strpos($mensaje, 'Error') !== false ? 'error' : ''); ?>;
        mostrarMensaje(mensaje, tipo);
    </script>
</body>
</html>
