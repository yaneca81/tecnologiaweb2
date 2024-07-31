<?php
include '../config/config.php';
include '../includes/header.php';
include '../logic/empleoLogic.php';
include '../logic/postulacionLogic.php';

$empleoId = $_GET['empleoid'] ?? null;
//$titulo = $_GET['titulo'] ?? '';
//$foto = $_GET['foto'] ?? '';
$empleo = null;

//$empleo['id'] = $empleoId;
//$empleo['titulo'] = $titulo;
//$empleo['foto'] = $foto;

if ($empleoId) {
    $empleo = obtenerEmpleoPorId($empleoId);
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = $_POST['mensaje'] ?? '';
    $archivo = $_FILES['archivo'];

    if (strlen($mensaje) === 0) {
        $errors['mensaje'] = 'Este campo no puede ir vacio';
    }
    else if(strlen($mensaje) > 220){
        $errors['mensaje'] = 'Este campo no puede exeder de los 220 caracteres';
    }

    if ($archivo['tmp_name'] == '') {
        $errors['archivo'] = 'El curriculum no puede estar vacio';
    }
    else if($archivo['type'] !== 'application/pdf'){
        $errors['archivo'] = 'El archivo debe ser en formato PDF';
    }

    $archivoPath = '../uploads/postulaciones/' . basename($archivo['name']);
    if (!move_uploaded_file($archivo['tmp_name'], $archivoPath)) {
        $errors['archivo'] = "Error al subir el archivo";
    }
    if (empty($errors)) {
        $postulacionData['userid'] = $_COOKIE['user_id'];
        $postulacionData['empleoid'] = $empleoId;
        $postulacionData['archivo'] = $archivoPath;
        $postulacionData['mensaje'] = $mensaje;
        if (insertpostularse($postulacionData)) {
            echo "Registro exitoso";
            header('Location: index.php');
            exit(); // Asegurarse de que el script se detenga aquí
            //$userData = ['user' => '', 'password' => '', 'nombre' => '', 'apellido' => '', 'correo' => '', 'telefono' => '', 'direccion' => ''];
        } else {
            echo "Error al postularse.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Postulación</title>
    <link rel="stylesheet" href="../assets/css/error.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
    <link rel="stylesheet" href="../assets/css/postulacion.css">
</head>
<body>
<main>
    <?php if ($empleo): ?>
        <h2><?php echo htmlspecialchars($empleo['titulo']); ?></h2>
        <img src="<?php echo htmlspecialchars($empleo['foto']); ?>" alt="<?php echo htmlspecialchars($empleo['titulo']); ?>">
        <p><?php echo htmlspecialchars($empleo['descripcion']); ?></p>

        <form method="POST" enctype="multipart/form-data">
            <label for="mensaje">Cuéntanos de ti:</label>
            <textarea id="mensaje" name="mensaje" maxlength="220"></textarea>
            <?php if (isset($errors['mensaje'])): ?><div class="error"><?php echo $errors['mensaje']; ?></div><?php endif; ?>

            <label for="archivo">Subir Currículum (PDF):</label>
            <input type="file" id="archivo" name="archivo" accept="application/pdf">
            <?php if (isset($errors['archivo'])): ?><div class="error"><?php echo $errors['archivo']; ?></div><?php endif; ?>

            <input type="hidden" name="empleo_id" value="<?php echo htmlspecialchars($empleoId); ?>">
            <button type="submit">Enviar Postulación</button>
        </form>
    <?php else: ?>
        <p>No se encontró el empleo.</p>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>
