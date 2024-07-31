<?php
session_start();
include_once '../incluye/funciones.php';

$errores = [];
$correo = $contraseña = $rol = $nombre = $apellido = $telefono = $direccion = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $contraseña = trim($_POST['contraseña']);
    $rol = $_POST['rol'];

    // Validaciones generales
    if (empty($correo)) {
        $errores['correo'] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo no es válido.";
    }

    if (empty($contraseña)) {
        $errores['contraseña'] = "La contraseña es obligatoria.";
    }

    if ($rol === 'candidato') {
        $nombre = is_string($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $telefono = isset($_POST['telefono']);

        if (empty($nombre)) {
            $errores['nombre'] = "El nombre es obligatorio.";
        }

        if (empty($apellido)) {
            $errores['apellido'] = "El apellido es obligatorio.";
        }

        if (empty($telefono)) {
            $errores['telefono'] = "El teléfono es obligatorio.";
        }

        if (empty($errores)) {
            $id_usuario = registrarCandidato($correo, $contraseña, $nombre, $apellido, $telefono);
            $_SESSION['usuario_id'] = $id_usuario;
            $_SESSION['rol'] = 'candidato';
            header('Location: ../candidatos/index.php');
            exit();
        }
    } elseif ($rol === 'empresa') {
        $nombre = trim($_POST['nombre']);
        $direccion = trim($_POST['direccion']);
        $telefono = trim($_POST['telefono']);

        if (empty($nombre)) {
            $errores['nombre'] = "El nombre de la empresa es obligatorio.";
        }

        if (empty($direccion)) {
            $errores['direccion'] = "La dirección es obligatoria.";
        }

        if (empty($telefono)) {
            $errores['telefono'] = "El teléfono es obligatorio.";
        }

        if (empty($errores)) {
            $id_usuario = registrarEmpresa($correo, $contraseña, $nombre, $direccion, $telefono);
            $_SESSION['usuario_id'] = $id_usuario;
            $_SESSION['rol'] = 'empresa';
            header('Location: ../empresas/index.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
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
            max-width: 500px;
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
        input[type="email"], input[type="password"], input[type="text"], select {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
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
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select name="rol" id="rol" required>
                    <option value="candidato" <?php echo $rol === 'candidato' ? 'selected' : ''; ?>>Candidato</option>
                    <option value="empresa" <?php echo $rol === 'empresa' ? 'selected' : ''; ?>>Empresa</option>
                </select>
            </div>
            <div id="candidato-fields" style="<?php echo $rol === 'candidato' ? 'display: block;' : 'display: none;'; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="<?php echo isset($errores['nombre']) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($nombre); ?>">
                    <?php if (isset($errores['nombre'])) { ?>
                        <p class="error"><?php echo htmlspecialchars($errores['nombre']); ?></p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" class="<?php echo isset($errores['apellido']) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($apellido); ?>">
                    <?php if (isset($errores['apellido'])) { ?>
                        <p class="error"><?php echo htmlspecialchars($errores['apellido']); ?></p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" class="<?php echo isset($errores['telefono']) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($telefono); ?>">
                    <?php if (isset($errores['telefono'])) { ?>
                        <p class="error"><?php echo htmlspecialchars($errores['telefono']); ?></p>
                    <?php } ?>
                </div>
            </div>
            <div id="empresa-fields" style="<?php echo $rol === 'empresa' ? 'display: block;' : 'display: none;'; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre de la Empresa:</label>
                    <input type="text" id="nombre" name="nombre" class="<?php echo isset($errores['nombre']) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($nombre); ?>">
                    <?php if (isset($errores['nombre'])) { ?>
                        <p class="error"><?php echo htmlspecialchars($errores['nombre']); ?></p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="<?php echo isset($errores['direccion']) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($direccion); ?>">
                    <?php if (isset($errores['direccion'])) { ?>
                        <p class="error"><?php echo htmlspecialchars($errores['direccion']); ?></p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" class="<?php echo isset($errores['telefono']) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($telefono); ?>">
                    <?php if (isset($errores['telefono'])) { ?>
                        <p class="error"><?php echo htmlspecialchars($errores['telefono']); ?></p>
                    <?php } ?>
                </div>
            </div>
            <input type="submit" value="Registrar">
        </form>
    </div>

    <script>
        document.getElementById('rol').addEventListener('change', function() {
            var rol = this.value;
            document.getElementById('candidato-fields').style.display = rol === 'candidato' ? 'block' : 'none';
            document.getElementById('empresa-fields').style.display = rol === 'empresa' ? 'block' : 'none';
        });
    </script>
</body>
</html>
s