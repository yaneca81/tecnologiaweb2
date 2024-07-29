<?php
include '../includes/conexion.php';

$errores = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $estado = trim($_POST['estado']);
    $rol = trim($_POST['rol']);

    //? Validación del nombre
    if (strlen($nombre) < 1 || strlen($nombre) > 20) {
        $errores['nombre'] = "El nombre debe tener entre 1 y 20 caracteres.";
    }

    //? Validación del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "El correo electrónico no es válido.";
    } else {
        //? Verificación de que el email sea único en la base de datos
        $sql = "SELECT id FROM usuarios WHERE email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $errores['email'] = "El correo electrónico ya está registrado.";
        }
    }

    //? Validación de la contraseña
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errores['password'] = "La contraseña debe contener letras y números.";
    }

    //? Validación del estado
    if ($estado !== 'Estudiante' && $estado !== 'Egresado') {
        $errores['estado'] = "El estado debe ser 'Estudiante' o 'Egresado'.";
    }

    //? Manejo de la imagen
    $imagen = $_FILES['imagen']['name'];
    $target_dir = "../imagenes/";
    $target_file = $target_dir . basename($imagen);
    
    //? Si no hay errores, proceder a registrar el usuario
    if (empty($errores)) {
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            $hash_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuarios (nombre, email, contraseña, imagen, estado, rol) VALUES ('$nombre', '$email', '$hash_password', '$imagen', '$estado', '$rol')";

            if ($conn->query($sql) === TRUE) {
                header("Location: registro.php?success=true");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        //? Mostrar errores en el formulario
        include 'registro.php';
    }
}
?>