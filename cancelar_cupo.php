<?php
include 'includes/insertar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cupo = isset($_POST['id_cupo']) ? intval($_POST['id_cupo']) : 0;

    if (cancelarCupo($id_cupo)) {
        echo "success";
    } else {
        echo "Error al cancelar el cupo.";
    }
}
?>

