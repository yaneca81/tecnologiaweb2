<?php
require 'conexion.php'; // Incluye el archivo de conexión

function obtenerCalificaciones() {
    $conn = conectar(); // Llama a la función para conectar con la base de datos

    $sql = "SELECT c.Id AS ID, c.Fecha AS Fecha, c.Nota AS Nota, t.Titulo AS Tarea, c.Calificacion AS Comentario
            FROM Calificacion c
            LEFT JOIN Tarea t ON c.Id_tarea = t.Id";
    
    $resultado = mysqli_query($conn, $sql);
    $calificaciones = [];
    
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $calificaciones[] = $fila;
        }
        mysqli_free_result($resultado);
    } else {
        echo "Error en la consulta: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
    return $calificaciones;
}
?>
