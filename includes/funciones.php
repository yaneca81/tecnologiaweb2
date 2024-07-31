<?php
require 'conexion.php';

function insertarTarea($titulo, $descripcion, $fecha_inicio, $fecha_final, $nombre_profesor, $nombre_materia) {
    $conn = conectar();

    // Buscar el ID del profesor por nombre
    $sql_profesor = "SELECT Id FROM Profesor WHERE Id_persona = (SELECT Id FROM Persona WHERE CONCAT(Nombre, ' ', Apellido) = ?)";
    $stmt_profesor = mysqli_prepare($conn, $sql_profesor);
    mysqli_stmt_bind_param($stmt_profesor, "s", $nombre_profesor);
    mysqli_stmt_execute($stmt_profesor);
    mysqli_stmt_bind_result($stmt_profesor, $id_profesor);
    mysqli_stmt_fetch($stmt_profesor);
    mysqli_stmt_close($stmt_profesor);

    if (!$id_profesor) {
        mysqli_close($conn);
        return "Profesor no encontrado: $nombre_profesor";
    }

    // Buscar el ID de la materia por nombre
    $sql_materia = "SELECT Id FROM Materia WHERE Nombre = ?";
    $stmt_materia = mysqli_prepare($conn, $sql_materia);
    mysqli_stmt_bind_param($stmt_materia, "s", $nombre_materia);
    mysqli_stmt_execute($stmt_materia);
    mysqli_stmt_bind_result($stmt_materia, $id_materia);
    mysqli_stmt_fetch($stmt_materia);
    mysqli_stmt_close($stmt_materia);

    if (!$id_materia) {
        mysqli_close($conn);
        return "Materia no encontrada: $nombre_materia";
    }

    // Insertar la tarea
    $sql = "INSERT INTO Tarea (Titulo, Descripcion, Fecha_inicio, Fecha_presentacion, Id_profesor, Id_materia) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssii", $titulo, $descripcion, $fecha_inicio, $fecha_final, $id_profesor, $id_materia);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($resultado) {
            mysqli_close($conn);
            return true;
        } else {
            mysqli_close($conn);
            return "Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt);
        }
    } else {
        mysqli_close($conn);
        return "Error en la preparación de la sentencia: " . mysqli_error($conn);
    }
}


function insertarReunion($tema, $fecha, $id_profesor) {
    $conn = conectar();
    
    // Separar la fecha y la hora
    $fecha_date = DateTime::createFromFormat('Y-m-d\TH:i', $fecha);
    if (!$fecha_date) {
        return "Formato de fecha no válido.";
    }
    
    $fecha_formateada = $fecha_date->format('Y-m-d');
    $hora_formateada = $fecha_date->format('H:i');
    
    // Consulta SQL para insertar la reunión
    $sql = "INSERT INTO Reunion (Titulo, Fecha, Hora, Id_profesor) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $tema, $fecha_formateada, $hora_formateada, $id_profesor);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $resultado ? true : "Error al ejecutar la consulta: " . mysqli_error($conn);
    } else {
        mysqli_close($conn);
        return "Error al preparar la consulta: " . mysqli_error($conn);
    }
}



// Insertar calificación en la base de datos
function insertarCalificacion($nombre_estudiante, $nombre_materia, $calificacion) {
    $conn = conectar();

    // Buscar el ID del estudiante por nombre (suponiendo que la relación es a través de id_persona)
    $sql_estudiante = "SELECT id FROM Estudiante WHERE id_persona = (SELECT Id FROM Persona WHERE CONCAT(Nombre, ' ', Apellido) = ?)";
    $stmt_estudiante = mysqli_prepare($conn, $sql_estudiante);
    mysqli_stmt_bind_param($stmt_estudiante, "s", $nombre_estudiante);
    mysqli_stmt_execute($stmt_estudiante);
    mysqli_stmt_bind_result($stmt_estudiante, $id_estudiante);
    mysqli_stmt_fetch($stmt_estudiante);
    mysqli_stmt_close($stmt_estudiante);

    if (!$id_estudiante) {
        mysqli_close($conn);
        return "Estudiante no encontrado: $nombre_estudiante";
    }

    // Buscar el ID de la materia por nombre
    $sql_materia = "SELECT Id FROM Materia WHERE Nombre = ?";
    $stmt_materia = mysqli_prepare($conn, $sql_materia);
    mysqli_stmt_bind_param($stmt_materia, "s", $nombre_materia);
    mysqli_stmt_execute($stmt_materia);
    mysqli_stmt_bind_result($stmt_materia, $id_materia);
    mysqli_stmt_fetch($stmt_materia);
    mysqli_stmt_close($stmt_materia);

    if (!$id_materia) {
        mysqli_close($conn);
        return "Materia no encontrada: $nombre_materia";
    }

    // Insertar calificación
    $sql = "INSERT INTO Calificacion (Id_estudiante, Id_materia, Calificacion) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iis", $id_estudiante, $id_materia, $calificacion);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $resultado ? true : "Error en la ejecución de la sentencia: " . mysqli_stmt_error($stmt);
    } else {
        mysqli_close($conn);
        return "Error en la preparación de la sentencia: " . mysqli_error($conn);
    }
}
// funciones.php
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
