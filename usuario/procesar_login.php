<?php
include '../includes/conexion.php';


$errores = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    
    //? validamos el email
    if (empty($email)) {
        $errores['email'] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "El correo electrónico no es válido.";
    }

    //? validamos la contraseña
    if (empty($password)) {
        $errores['password'] = "La contraseña es obligatoria.";
    }

    if (empty($errores)) {
        //? Consulta SQL para obtener el usuario por email
        $sql = "SELECT * FROM usuarios WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            //? Verificar la contraseña según el rol
            if ($usuario['rol'] == 'admin') {
                //? Para administradores, verificar la contraseña sin encriptar
                if ($password == $usuario['contraseña']) {
                    session_start();
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['rol'] = $usuario['rol'];
                    header('Location: ../admin/dashboard_admin.php');
                    exit();
                } else {
                    $errores['password'] = "Contraseña incorrecta.";
                }
            } else {
                //? Para usuarios, verificar la contraseña encriptada
                if (password_verify($password, $usuario['contraseña'])) {
                    session_start();
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['rol'] = $usuario['rol'];
                    header('Location: dashboard_usuario.php');
                    exit();
                } else {
                    $errores['password'] = "Contraseña incorrecta.";
                }
            }
        } else {
            $errores['email'] = "Usuario incorrecto";
        }
    }
    include 'login.php';
}
?>
