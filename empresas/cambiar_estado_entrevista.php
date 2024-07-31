<?php
session_start(); // Iniciar la sesión para manejar variables de sesión

// Incluir el archivo de funciones
include '../incluye/funciones.php';

// Obtener el rol del usuario
$rol_usuario = isset($_SESSION['usuario_id']) ? obtenerRolUsuario($_SESSION['usuario_id']) : null;

// Verificar si el usuario está autenticado como empresa
if ($rol_usuario !== 'empresa') {
    header('Location: ../autentificacion/iniciar_sesion.php');
    exit();
}

// Verificar que se han enviado los datos necesarios
if (!isset($_POST['id_entrevista']) || !isset($_POST['estado'])) {
    echo "Error: Datos incompletos.";
    exit();
}

$id_entrevista = $_POST['id_entrevista'];
$estado = $_POST['estado'];

// Actualizar el estado de la entrevista en la base de datos
$sql = "UPDATE entrevistas SET estado = ? WHERE id_entrevista = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'si', $estado, $id_entrevista);

if (mysqli_stmt_execute($stmt)) {
    $mensaje = "Estado de la entrevista actualizado con éxito.";
} else {
    $mensaje = "Error al actualizar el estado de la entrevista: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Estado - Empresa</title>
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
                window.location.href = 'entrevista.php'; // Redirigir a la página de entrevistas
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
