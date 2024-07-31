<?php
require 'includes/funciones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tema = $_POST['tema'];
    $fecha = $_POST['fecha'];
    $id_profesor = isset($_POST['id_profesor']) ? $_POST['id_profesor'] : null; // Verifica si 'id_profesor' está definido

    if ($id_profesor === null) {
        die("Error: ID del profesor no proporcionado.");
    }

    // Inserta la reunión en la base de datos
    $resultado = insertarReunion($tema, $fecha, $id_profesor);

    if ($resultado === true) {
        header("Location: reunion_programada.php"); // Redirige a una página de éxito
        exit();
    } else {
        echo "Error al programar la reunión: " . $resultado;
    }
}
?>
