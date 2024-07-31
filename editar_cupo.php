<?php
include 'includes/insertar.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cupo = isset($_POST['id_cupo']) ? intval($_POST['id_cupo']) : 0;
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
    $hora = isset($_POST['hora']) ? $_POST['hora'] : '';
    $id_taller = isset($_POST['id_taller']) ? intval($_POST['id_taller']) : 0;
    $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;

    if (editarCupo($id_cupo, $fecha, $hora, $id_taller, $estado)) {
        echo "success";
    } else {
        echo "Error al actualizar el cupo: " . mysqli_error($conn);
    }
}
?>
