<?php
include 'index.php';
require_once("includes/conexion.php");
require_once("includes/insertar.php");

$errorCupo = '';
$successCupo = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_cupo']) && isset($_POST['form_submitted'])) {
    $fecha = trim($_POST["fecha"]);
    $hora = trim($_POST["hora"]);
    $id_taller = trim($_POST["id_taller"]);
    $estado = trim($_POST["estado"]);

    if (empty($fecha) || empty($hora) || empty($id_taller) || empty($estado)) {
        $errorCupo = 'Todos los campos son obligatorios para el cupo.';
    } elseif ($id_taller <= 0) {
        $errorCupo = 'El ID del taller debe ser un número positivo.';
    } else {
        $count = contarCuposPorFecha($fecha);
        if ($count >= 3) {
            $errorCupo = 'Ya existen tres cupos registrados para esta fecha.';
        } else {
            if (insertarCupo($fecha, $hora, $id_taller, $estado)) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                exit();
            } else {
                $errorCupo = 'Error al registrar el cupo. Verifica los detalles e intenta nuevamente.';
            }
        }
    }
}

if (isset($_GET['success'])) {
    $successCupo = 'Cupo registrado exitosamente.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cupo</title>
    <link rel="stylesheet" href="estilos/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .registro-cupo {
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
        <section class="registro-cupo">
            <h2>Registrar Cupo</h2>
            <?php if ($errorCupo): ?>
                <p class="error"><?php echo $errorCupo; ?></p>
            <?php endif; ?>
            <?php if ($successCupo): ?>
                <p class="success"><?php echo $successCupo; ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <input type="hidden" name="form_submitted" value="1">
                <div class="form-group">
                    <label for="fecha">Fecha de Registro:</label>
                    <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fecha ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="hora">Hora de entrega:</label>
                    <input type="time" id="hora" name="hora" value="<?php echo htmlspecialchars($hora ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="id_taller">Numero de taller:</label>
                    <input type="number" id="id_taller" name="id_taller" value="<?php echo htmlspecialchars($id_taller ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="estado">estado:</label>
                    <input type="number" id="estado" name="estado" value="<?php echo htmlspecialchars($estado ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="registrar_cupo">Registrar Cupo</button> <br> <br>
                    <button type="button" onclick="location.href='../cupos.php'">Cancelar</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

