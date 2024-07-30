<?php
include '../config/config.php';
//include '../includes/header.php';
include '../logic/auth.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_COOKIE['user_id'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_COOKIE['user_id'];
$usuario = obtenerUsuario($id_usuario);
($usuario['rol'] == 'estudiante')? include '../includes/header.php' : include '../includes/header_admin.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $foto = $_FILES['foto'];

    // Validar datos
    if (empty($nombre) || strlen($nombre) > 20) {
        $errors['nombre'] = "El nombre es obligatorio y no debe exceder los 20 caracteres.";
    }

    if (empty($apellido) || strlen($apellido) > 20) {
        $errors['apellido'] = "El apellido es obligatorio y no debe exceder los 20 caracteres.";
    }

    if (empty($correo) || strlen($correo) > 50) {
        $errors['correo'] = "El correo es obligatorio y no debe exceder los 50 caracteres.";
    } elseif (emailExists($correo, $id_usuario)) {
        $errors['correo'] = "Este correo ya está en uso.";
    }

    if (strlen($telefono) > 11 || strlen($telefono) < 8) {
        $errors['telefono'] = "El teléfono debe tener entre 8 y 11 dígitos.";
    }

    if (strlen($direccion) > 50) {
        $errors['direccion'] = "La dirección no debe exceder los 50 caracteres.";
    }

    $fotoPath = $usuario['foto'];
    if (!empty($foto['tmp_name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($foto['type'], $allowedTypes)) {
            $errors['foto'] = "El archivo debe ser una imagen (jpeg, png, jpg).";
        } else {
            $fotoPath = '../uploads/usuarios/' . basename($foto['name']);
            if (!move_uploaded_file($foto['tmp_name'], $fotoPath)) {
                $errors['foto'] = "Error al subir la imagen.";
            }
        }
    }

    // Si no hay errores, actualizar el usuario
    if (empty($errors)) {
        if (actualizarUsuario($id_usuario, $nombre, $apellido, $correo, $telefono, $direccion, $fotoPath)) {
            //correccion error al actualizar foto
            setcookie("user_photo", $fotoPath, time() + (86400 * 30), "/");
            header('Location: perfil.php');
            exit();
        } else {
            $errors['general'] = "Error al actualizar el perfil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../assets/css/editarPerfil.css">
</head>
<body>
    <div class="form-container">
        <form method="POST" action="" enctype="multipart/form-data" class="transparent-form">
            <img src="<?php echo $usuario['foto']; ?>" alt="Foto de perfil" id="fotoPerfil">
            
            <h2>Editar Perfil</h2>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            <?php if (isset($errors['nombre'])): ?><div class="error"><?php echo $errors['nombre']; ?></div><?php endif; ?>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
            <?php if (isset($errors['apellido'])): ?><div class="error"><?php echo $errors['apellido']; ?></div><?php endif; ?>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
            <?php if (isset($errors['correo'])): ?><div class="error"><?php echo $errors['correo']; ?></div><?php endif; ?>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
            <?php if (isset($errors['telefono'])): ?><div class="error"><?php echo $errors['telefono']; ?></div><?php endif; ?>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" required>
            <?php if (isset($errors['direccion'])): ?><div class="error"><?php echo $errors['direccion']; ?></div><?php endif; ?>

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto">
            <?php if (isset($errors['foto'])): ?><div class="error"><?php echo $errors['foto']; ?></div><?php endif; ?>

            <button class="buttons" type="submit">Actualizar Perfil</button>
            <?php if (isset($errors['general'])): ?><div class="error"><?php echo $errors['general']; ?></div><?php endif; ?>
        </form>
    </div>

    <script>
    document.getElementById('foto').onchange = function(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('fotoPerfil').src = URL.createObjectURL(file);
        }
    };
    </script>
</body>
</html>

<?php include '../includes/footer.php'; ?>
