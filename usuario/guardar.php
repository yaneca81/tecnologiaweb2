<?php
    session_start();
    require('../includes/conexion.php');

    if (isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $usuarioid = intval($_GET['id']);
        $_SESSION['IdUsuario'] = $usuarioid;
        header("Location: portafolio2.php");
        exit();
    }
?>