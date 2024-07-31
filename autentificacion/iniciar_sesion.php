
<?php
session_start();
include_once '../incluye/funciones.php';

$errores = [];
$correo = $contraseña = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $contraseña = trim($_POST['contraseña']);

    if (empty($correo)) {
        $errores['correo'] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo no es válido.";
    }

    if (empty($contraseña)) {
        $errores['contraseña'] = "La contraseña es obligatoria.";
    }

    if (empty($errores)) {
        $usuario = autenticar_usuario($correo, $contraseña);

        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['rol'] = $usuario['rol'];

            if ($usuario['rol'] == 'candidato') {
                header('Location: ../candidatos/index.php');
            } elseif ($usuario['rol'] == 'empresa') {
                header('Location: ../empresas/index.php');
            } else {
                header('Location: ../index.php');
            }
            exit();
        } else {
            $errores['general'] = "Correo o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            display: block;
        }
        input[type="email"], input[type="password"] {
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .input-error {
            border-color: #f44336;
        }
        .error {
            color: #f44336;
            font-size: 0.875em;
            margin: 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
        .register-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" class="<?php echo isset($errores['correo']) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($correo); ?>">
                <?php if (isset($errores['correo'])) { ?>
                    <p class="error"><?php echo htmlspecialchars($errores['correo']); ?></p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="<?php echo isset($errores['contraseña']) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($contraseña); ?>">
                <?php if (isset($errores['contraseña'])) { ?>
                    <p class="error"><?php echo htmlspecialchars($errores['contraseña']); ?></p>
                <?php } ?>
            </div>
            <?php if (isset($errores['general'])) { ?>
            <p class="error"><?php echo htmlspecialchars($errores['general']); ?></p>
        <?php } ?><br>
            <input type="submit" value="Iniciar Sesión">
        </form>
        <div class="register-link">
            <a href="registro.php">Registrarse</a>
        </div>
    </div>
</body>
</html>
