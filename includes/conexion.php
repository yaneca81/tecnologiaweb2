<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$bd = "practicas_profesionales";

$conn = new mysqli($servidor, $usuario, $contraseña, $bd);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
