<?php
require 'includes/funciones.php';

// Obtener datos del formulario
$nombre_estudiante = $_POST['estudiante'];
$nombre_materia = $_POST['materia'];
$calificacion = $_POST['calificacion'];

// Insertar calificación
$resultado = insertarCalificacion($nombre_estudiante, $nombre_materia, $calificacion);

if ($resultado === true) {
    header('Location: calificaciones.php'); // Redirigir a la lista de calificaciones
} else {
    echo "Error: " . $resultado;
}
?>
