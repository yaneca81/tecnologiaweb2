<?php
include '../includes/header_admin.php';
include '../logic/usuarioAdminLogic.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['user']);
    $password = trim($_POST['password']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $foto = $_FILES['foto'];

    $errors = [];

    if (empty($user) || strlen($user) > 20) {
        $errors['user'] = "El usuario es obligatorio y no debe exceder los 20 caracteres.";
    }
    if (empty($password) || strlen($password) > 255) {
        $errors['password'] = "La contraseña es obligatoria y no debe exceder los 255 caracteres.";
    }
    if (empty($nombre) || strlen($nombre) > 20) {
        $errors['nombre'] = "El nombre es obligatorio y no debe exceder los 20 caracteres.";
    }
    if (empty($apellido) || strlen($apellido) > 20) {
        $errors['apellido'] = "El apellido es obligatorio y no debe exceder los 20 caracteres.";
    }
    if (empty($correo) || strlen($correo) > 50) {
        $errors['correo'] = "El correo es obligatorio y no debe exceder los 50 caracteres.";
    }
    if (empty($telefono) || strlen($telefono) > 11 || strlen($telefono) < 8) {
        $errors['telefono'] = "El teléfono debe tener entre 8 y 11 dígitos.";
    }
    if (empty($direccion) || strlen($direccion) > 50) {
        $errors['direccion'] = "La dirección es obligatoria y no debe exceder los 50 caracteres.";
    }

    $fotoPath = '../uploads/usuarios/sinFoto.png';
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

    if (empty($errors)) {
        if (agregarUsuarioAdmin($user, $password, $nombre, $apellido, $correo, $telefono, $direccion, $fotoPath)) {
            header('Location: usuarioAdmin.php');
            exit();
        } else {
            $errors['general'] = "Error al agregar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario Admin</title>
    <link rel="stylesheet" href="../assets/css/error.css">
    <link rel="stylesheet" href="../assets/css/agregarUsuarioAdmin.css">
</head>
<body>
<main>
    <h2>Agregar Usuario Admin</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="user">Usuario:</label>
        <input type="text" id="user" name="user" value="<?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : ''; ?>" required>
        <?php if (isset($errors['user'])): ?><div class="error"><?php echo $errors['user']; ?></div><?php endif; ?>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
        <?php if (isset($errors['password'])): ?><div class="error"><?php echo $errors['password']; ?></div><?php endif; ?>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
        <?php if (isset($errors['nombre'])): ?><div class="error"><?php echo $errors['nombre']; ?></div><?php endif; ?>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : ''; ?>" required>
        <?php if (isset($errors['apellido'])): ?><div class="error"><?php echo $errors['apellido']; ?></div><?php endif; ?>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" required>
        <?php if (isset($errors['correo'])): ?><div class="error"><?php echo $errors['correo']; ?></div><?php endif; ?>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>" required>
        <?php if (isset($errors['telefono'])): ?><div class="error"><?php echo $errors['telefono']; ?></div><?php endif; ?>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>" required>
        <?php if (isset($errors['direccion'])): ?><div class="error"><?php echo $errors['direccion']; ?></div><?php endif; ?>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto">
        <?php if (isset($errors['foto'])): ?><div class="error"><?php echo $errors['foto']; ?></div><?php endif; ?>

        <button type="submit">Agregar Usuario Admin</button>
        <?php if (isset($errors['general'])): ?><div class="error"><?php echo $errors['general']; ?></div><?php endif; ?>
    </form>
</main>
</body>
</html>

<?php include '../includes/footer.php'; ?>
