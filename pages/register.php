<?php
include '../config/config.php';
include '../logic/UserLogic.php';

if (isset($_COOKIE['user_id'])) {
    header('Location: ../pages/index.php');
    exit();
}

// Variables para almacenar errores y valores anteriores
$errors = [];
$userData = ['user' => '', 'password' => '', 'nombre' => '', 'apellido' => '', 'correo' => '', 'telefono' => '', 'direccion' => ''];

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData['user'] = isset($_POST['user'])? $_POST['user'] : '';
    $userData['password'] = isset($_POST['password'])? $_POST['password'] : '';
    $userData['nombre'] = isset($_POST['nombre'])? $_POST['nombre'] : '';
    $userData['apellido'] = isset($_POST['apellido'])? $_POST['apellido'] : '';
    $userData['correo'] = isset($_POST['correo'])? $_POST['correo'] : '';
    $userData['telefono'] = isset($_POST['telefono'])? $_POST['telefono'] : '';
    $userData['direccion'] = isset($_POST['direccion'])? $_POST['direccion'] : '';
    $foto = $_FILES['foto'];

    // Validar datos
    if(empty($userData['user'])){
        $errors['user'] = "El nombre no puede estar vacio";
    }
    elseif(strlen($userData['user']) > 20) {
        $errors['user'] = "El nombre de usuario no debe exceder los 20 caracteres.";
    }
    if(empty($userData['user'])){
        $errors['user'] = "El usuario no debe estar vacio";
    }
    elseif(userExists($userData['user'])) {
        $errors['user'] = "Este usuario ya está en uso.";
    }
    if(empty($userData['password'])){
        $errors['password'] = "La contraseña no puede estar vacia";
    }
    elseif(strlen($userData['password']) > 255) {
        $errors['password'] = "La contraseña no debe exceder los 255 caracteres.";
    }
    if($userData['nombre']){
        $errors['nombre'] = "El nombre no puede estar vacio";
    }
    elseif(strlen($userData['nombre']) > 20) {
        $errors['nombre'] = "El nombre no debe exceder los 20 caracteres.";
    }
    if(empty($userData['apellido'])){
        $errors['apellido'] = "El apellido no puede estar vacio";
    }
    elseif(strlen($userData['apellido']) > 20) {
        $errors['apellido'] = "El apellido no debe exceder los 20 caracteres.";
    }
    if(empty($userData['correo'])){
        $errors['correo'] = "El correo no puede estar vacio";
    }
    elseif(strlen($userData['correo']) > 50) {
        $errors['correo'] = "El correo no debe exceder los 50 caracteres.";
    }
    if(emailExists($userData['correo'])){
        $errors['correo'] = "Este correo ya esta uso";
    }
    if (strlen($userData['telefono']) > 11 || strlen($userData['telefono']) < 8) {
        $errors['telefono'] = "El teléfono debe tener entre 8 y 11 dígitos.";
    }
    if (strlen($userData['direccion']) > 50) {
        $errors['direccion'] = "La dirección no debe exceder los 50 caracteres.";
    }

    // Validar la imagen
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    if(empty($foto['tpm_name'])){
        $errors['foto'] = "La imagen esta vacia";
    }
    else if (!in_array($foto['type'], $allowedTypes)) {
        $errors['foto'] = "El archivo debe ser una imagen (jpeg, png, jpg).";
    } else {
        $fotoPath = '../uploads/usuarios/' . basename($foto['name']);
        if (!move_uploaded_file($foto['tmp_name'], $fotoPath)) {
            $errors['foto'] = "Error al subir la imagen.";
        }
    }

    // Si no hay errores, insertar el usuario
    if (empty($errors)) {
        $userData['foto'] = $fotoPath;  // Guardar la ruta de la foto
        if (insertUser($userData)) {
            echo "Registro exitoso";
            //para redirigir
            header('Location: ../pages/login.php');
            exit(); // Asegurarse de que el script se detenga aquí
            $userData = ['user' => '', 'password' => '', 'nombre' => '', 'apellido' => '', 'correo' => '', 'telefono' => '', 'direccion' => ''];
        } else {
            echo "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="user">Usuario:</label>
        <input type="text" id="user" name="user" value="<?php echo htmlspecialchars($userData['user']); ?>" >
        <?php if (isset($errors['user'])): ?><div class="error"><?php echo $errors['user']; ?></div><?php endif; ?>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($userData['password']); ?>" >
        <?php if (isset($errors['password'])): ?><div class="error"><?php echo $errors['password']; ?></div><?php endif; ?>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($userData['nombre']); ?>" >
        <?php if (isset($errors['nombre'])): ?><div class="error"><?php echo $errors['nombre']; ?></div><?php endif; ?>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($userData['apellido']); ?>" >
        <?php if (isset($errors['apellido'])): ?><div class="error"><?php echo $errors['apellido']; ?></div><?php endif; ?>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($userData['correo']); ?>" >
        <?php if (isset($errors['correo'])): ?><div class="error"><?php echo $errors['correo']; ?></div><?php endif; ?>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($userData['telefono']); ?>" >
        <?php if (isset($errors['telefono'])): ?><div class="error"><?php echo $errors['telefono']; ?></div><?php endif; ?>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($userData['direccion']); ?>" >
        <?php if (isset($errors['direccion'])): ?><div class="error"><?php echo $errors['direccion']; ?></div><?php endif; ?>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" >
        <?php if (isset($errors['foto'])): ?><div class="error"><?php echo $errors['foto']; ?></div><?php endif; ?>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
