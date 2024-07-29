<?php
include '../includes/conexion.php';

$errores = [];
$titulo = '';
$descripcion = '';
$categoria = '';
$empresa = '';
$email_contacto = '';
$imagen = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $empresa = $_POST['empresa'];
    $email_contacto = $_POST['contacto'];

    //? validamos título
    if (empty($titulo)) {
        $errores['titulo'] = "El título es obligatorio.";
    }

    //? validamos descripción
    if (empty($descripcion)) {
        $errores['descripcion'] = "La descripción es obligatoria.";
    }

    //? validamos categoría
    if (empty($categoria)) {
        $errores['categoria'] = "La categoría es obligatoria.";
    }

    //? validamos empresa
    if (empty($empresa)) {
        $errores['empresa'] = "El nombre de la empresa es obligatorio.";
    }

    //? validamos email de contacto
    if (empty($email_contacto)) {
        $errores['contacto'] = "El correo de contacto es obligatorio.";
    } elseif (!filter_var($email_contacto, FILTER_VALIDATE_EMAIL)) {
        $errores['contacto'] = "El formato del correo electrónico es incorrecto.";
    }

    //? validamos imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_ext = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));

        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imagen_ext, $allowed_ext)) {
            $errores['imagen'] = "La imagen debe ser de tipo jpg, jpeg, png o gif.";
        } else {
            move_uploaded_file($imagen_tmp, "../imagenes/$imagen");
        }
    } else {
        $errores['imagen'] = "La imagen es obligatoria.";
    }

    //? aqui insertamos en caso de que no haya errores
    if (empty($errores)) {
        $sql = "INSERT INTO ofertas (titulo, descripcion, categoria, empresa, email_contacto, imagen) VALUES ('$titulo', '$descripcion', '$categoria', '$empresa', '$email_contacto', '$imagen')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: crear_oferta.php?success=true");
            exit();
        } else {
            $errores['general'] = "Error al crear la oferta: " . $conn->error;
        }
    }
}

//? el formulario donde va a crear las valdiaciones
include "crear_oferta.php";
?>
