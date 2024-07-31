<?php include 'index.php'; ?>
<?php
require_once("includes/insertar.php");
$errorVehiculo = '';
$successVehiculo = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_vehiculo'])) {
    $marca = trim($_POST["marca"]);
    $modelo = trim($_POST["modelo"]);
    $año = trim($_POST["año"]);
    $id_usuario = trim($_POST["id_usuario"]);

    if (empty($marca) || empty($modelo) || empty($año) || empty($id_usuario)) {
        $errorVehiculo = 'Todos los campos son obligatorios para el vehículo.';
    } elseif ($año < 1900 || $año > 2100) {
        $errorVehiculo = 'El año debe estar entre 1900 y 2100.';
    } elseif ($id_usuario <= 0) {
        $errorVehiculo = 'El ID del usuario debe ser un número positivo.';
    } else {
        insertarVehiculo($marca, $modelo, $año, $id_usuario);
        $successVehiculo = 'Vehículo registrado exitosamente.';
        $marca = $modelo = $año = $id_usuario = '';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehículo</title>
    <link rel="stylesheet" href="../estilos/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .registro-vehiculo {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <main>
        <section class="registro-vehiculo">
            <h2>Registrar Vehículo</h2>
            <?php if ($errorVehiculo): ?>
                <p class="error"><?php echo $errorVehiculo; ?></p>
            <?php endif; ?>
            <?php if ($successVehiculo): ?>
                <p class="success"><?php echo $successVehiculo; ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($marca); ?>" required>
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($modelo); ?>" required>
                </div>
                <div class="form-group">
                    <label for="año">Año:</label>
                    <input type="number" id="año" name="año" value="<?php echo htmlspecialchars($año); ?>" required min="1900" max="2100">
                </div>
                <div class="form-group">
                    <label for="id_usuario">ID del Usuario:</label>
                    <input type="number" id="id_usuario" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="registrar_vehiculo">Registrar Vehículo</button><br> <br>
                    <button type="button" onclick="location.href='../cupos.php'">Cancelar</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

