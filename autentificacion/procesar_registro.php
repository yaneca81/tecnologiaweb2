<?php
include '../incluye/funciones.php';

$correo = $_POST['correo'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];

if ($rol === 'candidato') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];

    $id_usuario = registrarUsuario($correo, $contraseña, $rol);

    registrarCandidato($id_usuario, $nombre, $apellido, $telefono);

    header('Location: ../candidatos/index.php');
    exit();

} else if ($rol === 'empresa') {
    $nombre_empresa = $_POST['nombre_empresa'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $id_usuario = registrarUsuario($correo, $contraseña, $rol);

    registrarEmpresa($id_usuario, $nombre_empresa, $direccion, $telefono);

    header('Location: ../empresas/index.php');
    exit();
}
?>
