<?php
include '../config/config.php';

function obtenerEmpleos() {
    global $conn;
    $sql = '';
    if (isset($_COOKIE['user_id'])) {
        $userid = $_COOKIE['user_id'];
        $sql = 'SELECT e.*
                FROM empleo e
                LEFT JOIN postulacion p ON e.id = p.id_empleo AND p.id_usuario = '.$userid.'
                WHERE p.id_empleo IS NULL
                AND e.estado = 1;';
    }
    else{
        $sql = "SELECT * FROM empleo WHERE estado = 1";
    }
    $result = $conn->query($sql);
    $empleos = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $empleos[] = $row;
        }
    }
    return $empleos;
}

function obtenerEmpleoPorId($id){
    global $conn;
    $sql = "SELECT * FROM empleo WHERE id = " . $id;
    $result = $conn->query($sql);
    $empleos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $empleos[] = $row;
        }
    }
    else return [];
    return $empleos[0];
}

?>
