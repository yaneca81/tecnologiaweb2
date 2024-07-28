<?php
include '../config/config.php';
include '../logic/auth.php';

// Redirigir si ya ha iniciado sesión
if (isset($_COOKIE['user_id'])) {
    header('Location: ../pages/index.php');
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
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="">
        <label for="usernameOrEmail">Usuario o Correo:</label>
        <input type="text" id="usernameOrEmail" name="usernameOrEmail" value="<?php echo htmlspecialchars($usernameOrEmail); ?>" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
        <?php if (isset($errors['login'])): ?><div class="error"><?php echo $errors['login']; ?></div><?php endif; ?>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
