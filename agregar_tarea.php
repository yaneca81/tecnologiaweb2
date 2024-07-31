<?php
require 'includes/funciones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $profesor = $_POST['profesor'];
    $materia = $_POST['materia'];

    // Inserta la tarea en la base de datos
    $resultado = insertarTarea($titulo, $descripcion, $fecha_inicio, $fecha_final, $profesor, $materia);

    if ($resultado === true) {
        header("Location: tarea_agregada.php");
        exit();
    } else {
        echo "Error al agregar la tarea: " . $resultado;
    }
}
?>
