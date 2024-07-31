<?php
    function Conectar()
    {
        $conexion = mysqli_connect("127.0.0.1", "root", "", "cvnest");
        if (!$conexion) 
        {
            echo "Error: No se pudo conectar a MySQL:" . mysqli_connect_error();
            exit;
        }
        return $conexion;
    }
?>