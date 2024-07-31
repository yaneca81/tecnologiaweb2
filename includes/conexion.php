<?php
// Archivo: includes/conexion.php

function conectar() {
    $conn = mysqli_connect("localhost", "root", "", "proyecto");
    if (!$conn) {
        die("Error en la conexion: " . mysqli_connect_error());
    }
    return $conn;
}
?>
