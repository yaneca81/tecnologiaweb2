<?php
include '../config/config.php';
include '../logic/postulacionLogic.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_COOKIE['user_id'];
    $id_empleo = $_POST['empleo_id'];
    $mensaje = trim($_POST['mensaje']);
    $archivo = $_FILES['archivo'];

    $errors = [];

    // Validar mensaje
    if (empty($mensaje) || strlen($mensaje) > 220) {
        $errors['mensaje'] = "El mensaje es obligatorio y no debe exceder los 220 caracteres.";
    }

    // Validar archivo
    $allowedTypes = ['application/pdf'];
    if (empty($archivo['tmp_name']) || !in_array($archivo['type'], $allowedTypes)) {
        $errors['archivo'] = "El archivo es obligatorio y debe ser un PDF.";
    } else {
        $archivoPath = '../uploads/postulaciones/' . basename($archivo['name']);
        if (!move_uploaded_file($archivo['tmp_name'], $archivoPath)) {
            $errors['archivo'] = "Error al subir el archivo.";
        }
    }

    if (empty($errors)) {
        if (postularse($id_usuario, $id_empleo, $mensaje, $archivoPath)) {
            header('Location: ../index.php');
            exit();
        } else {
            echo "Error al registrar la postulación.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Postularse</title>
    <link rel="stylesheet" href="../assets/css/error.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
</head>
<body>
<main>
    <h2>Postulación</h2>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
