<?php
require_once 'model/UserModel.php';

$userModel = new UserModel();

// Obtener todos los usuarios
$usuarios = $userModel->select('correo')->get();

function getError($field)
{
    global $errors;
    if (isset($errors[$field])) {
        echo $errors[$field];
    }
}

function repeatedEmail($email)
{
    global $usuarios;
    $isRepeated = false;
    foreach ($usuarios as $key => $usuario) {
        if ($usuario['correo'] == $email) {
            $isRepeated = true;
        }
    }
    return $isRepeated;
}

function isValidPassword($password)
{
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';

    $hasLetter = false;
    $hasNumber = false;

    for ($i = 0; $i < strlen($password); $i++) {
        if (strpos($letters, $password[$i]) !== false) {
            $hasLetter = true;
        }
        if (strpos($numbers, $password[$i]) !== false) {
            $hasNumber = true;
        }
    }



    return $hasLetter && $hasNumber;
}

$nombre = $correo = $contrasena = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? '';
    $correo = $_POST["correo"] ?? '';
    $contrasena = $_POST["contrasena"] ?? '';


    if (empty($nombre)) {
        $errors['nombre'] = "El nombre es obligatorio.";
    } elseif (strlen($nombre) < 5) {
        $errors['nombre'] = "El nombre debe tener al menos 5 caracteres.";
    } else if (strlen($nombre) > 50) {
        $errors['nombre'] = "El nombre no debe tener más de 50 caracteres.";
    }

    if (empty($correo)) {
        $errors['correo'] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errors['correo'] = "El correo no es válido.";
    } elseif (repeatedEmail($correo)) {
        $errors['correo'] = "El correo ingresado ya se encuentra en uso.";
    }

    if (empty($contrasena)) {
        $errors['contrasena'] = "La contraseña es obligatoria.";
    } elseif (strlen($contrasena) < 4) {
        $errors['contrasena'] = "La contraseña debe tener al menos 4 caracteres.";
    } elseif (strlen($contrasena) > 40) {
        $errors['contrasena'] = "La contraseña  no debe tener más de 40 caracteres.";
    } elseif (!isValidPassword($contrasena)) {
        $errors['contrasena'] = "La contraseña debe incluir al menos una letra y un número.";
    }

    if (empty($errors)) {
        echo "<a href='login.php'>Iniciar Sesion</a>";

        $userModel->create([
            'nombre' => $nombre,
            'correo' => $correo,
            'contrasena' => password_hash($contrasena, PASSWORD_DEFAULT)
        ]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/sign.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/style.css">
    <title>Registro de Usuario</title>
</head>

<body>
    <main>
        <form class="form" action="" method="post">
            <p class="title">Registro de Usuario</p>
            <p class="message">Registrate y obten acceso completo a nuestra plataforma. </p>

            <div class="flex">
                <label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" type="text" class="input">
                    <span>Nombre</span>
                    <div class="error">
                        <?php getError('nombre'); ?>
                    </div>
                </label>
            </div>

            <label>
                <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" class="input">
                <span>Correo</span>
                <div class="error">
                    <?php getError('correo'); ?>
                </div>
            </label>


            <label>
                <input type="password" id="contrasena" name="contrasena" class="input">
                <span>Contraseña</span>
                <div class="error">
                    <?php getError('contrasena'); ?>
                </div>
            </label>
            <input type="submit" value="Submit" class="btn btn-success">
            <p class="signin">Ya tienes una cuenta? <a href="login.php">Iniciar Sesion</a> </p>
        </form>
    </main>
</body>

</html>