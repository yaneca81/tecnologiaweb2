<?php

$servidor = "localhost"; 
$usuario = "root";       
$contraseña = "";        
$base_de_datos = "ofertas";

$conn = mysqli_connect($servidor, $usuario, $contraseña, $base_de_datos);

if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>
