<?php
include 'conexion.php';
function contarCuposPorFecha($fecha) {
    global $conn;
    $fecha = mysqli_real_escape_string($conn, $fecha);
    $sql = "SELECT COUNT(*) as count FROM cupos WHERE fecha = '$fecha'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Consulta fallida: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function insertarCupo($fecha, $hora, $id_taller, $estado) {
    global $conn;
    $fecha = mysqli_real_escape_string($conn, $fecha);
    $hora = mysqli_real_escape_string($conn, $hora);
    $id_taller = (int)$id_taller;
    $estado = (int)$estado;

    $sql = "INSERT INTO cupos (fecha, hora, id_taller, estado) VALUES ('$fecha', '$hora', $id_taller, $estado)";
    
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function verificarTaller($id_taller) {
    global $conn;
    $id_taller = (int)$id_taller;
    $sql = "SELECT COUNT(*) as count FROM talleres WHERE id_taller = '$id_taller'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}
function listar() {
    global $conn;
    $sql = "SELECT cupos.*, talleres.nombre FROM cupos JOIN talleres ON cupos.id_taller = talleres.id_taller";
    $r = mysqli_query($conn, $sql);

    if (!$r) {
        die("Error en la consulta: " . mysqli_error($conn));
    }
    $datos = [];
    while ($fila = mysqli_fetch_assoc($r)) {
        $datos[] = $fila;
    }

    return $datos;
}
// funciones de editar, eliminar, cancelar cupo
function editarCupo($id_cupo, $fecha, $hora, $id_taller, $estado) {
    global $conn;
    $sql = "UPDATE cupos SET fecha = ?, hora = ?, id_taller = ?, estado = ? WHERE id_cupo = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    $stmt->bind_param("ssiii", $fecha, $hora, $id_taller, $estado, $id_cupo);
    $stmt->execute();
    
    return $stmt->affected_rows > 0;
}

function eliminarCupo($id_cupo) {
    global $conn;
    $sql = "DELETE FROM cupos WHERE id_cupo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cupo);
    $stmt->execute();
    
    return $stmt->affected_rows > 0;
}

function cancelarCupo($id_cupo) {
    global $conn;
    $sql = "UPDATE cupos SET estado = 0 WHERE id_cupo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cupo);
    $stmt->execute();
    
    return $stmt->affected_rows > 0;
}
?>

