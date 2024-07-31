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

// Verificar si se ha enviado una solicitud de cancelación
if (isset($_POST['id_entrevista']) && $_POST['accion'] === 'cancelar') {
    $id_entrevista = $_POST['id_entrevista'];
    cancelarEntrevista($id_entrevista);
    header('Location: entrevistas.php');
    exit();
}

// Redirigir si no se ha enviado una solicitud válida
header('Location: entrevistas.php');
exit();
?>

