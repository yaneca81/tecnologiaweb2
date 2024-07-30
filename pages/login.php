<?php
include '../config/config.php';
include '../logic/auth.php';

// Redirigir si ya ha iniciado sesión
if (isset($_COOKIE['user_id'])) {
    header('Location: index.php');
    exit();
}

// Variables para almacenar errores y valores anteriores
$errors = [];
$usernameOrEmail = '';
$password = '';

// Manejar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['usernameOrEmail']);
    $password = trim($_POST['password']);

    $user = verifyCredentials($usernameOrEmail, $password);

    if ($user) {
        // Crear cookies para mantener la sesión
        setcookie("user_id", $user['id'], time() + (86400 * 30), "/"); // 30 días
        setcookie("user_name", $user['user'], time() + (86400 * 30), "/");
        setcookie("user_role", $user['rol'], time() + (86400 * 30), "/");
        setcookie("user_photo", $user['foto'], time() + (86400 * 30), "/");

        if ($user['rol'] == 'admin') {
            header('Location: dashboard.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        $errors['login'] = "Credenciales incorrectas. Por favor, inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/css/error.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&family=Indie+Flower&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1 class="centrar">INICIAR SESIÓN</h1>
        <img src="../assets/images/randall job negro.png" class="logoRandall" alt="">
        <form method="POST" action="" class="transparent-form">

            <label for="usernameOrEmail">Usuario o Correo:</label>
            <input class="transparent-input input custom-input" type="text" id="usernameOrEmail" name="usernameOrEmail" value="<?php echo htmlspecialchars($usernameOrEmail); ?>" required>
            <?php if (isset($errors['login'])): ?><div class="error"><?php echo $errors['login']; ?></div><?php endif; ?>

            <label for="password">Contraseña:</label>
            <input class="transparent-input input custom-input" type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>

            <button class="buttons" type="submit">Iniciar Sesión</button>
            
            <div class="register-link">
                <span>¿No tienes cuenta? </span><a href="register.php">Crear cuenta</a>
            </div>
            <div class="register-link">
                <span>Ver sin iniciar sesión </span><a href="index.php">Home</a>
            </div>
        </form>
    </div>
</body>
</html>
