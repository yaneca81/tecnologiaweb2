<?php
$conn = mysqli_connect("localhost", "root", "", "mantenimientov");

if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>