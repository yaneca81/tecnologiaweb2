<?php
$host = 'localhost';
$db = 'EmpleosBD';
$user = 'root';
$pass = '0000';
// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

/*
try {
    function conex(){
        $host = 'localhost';
        $db = 'EmpleosBD';
        $user = 'root';
        $pass = '0000';
        $conn = new mysqli($host, $user, $pass, $db);
        echo "Conectado";
        return $conn;
    }
} catch (e) {
    echo "Error al conectar con la base de datos Revisar Config.php";
}*/
?>