<?php
include 'includes/conexion.php';
include 'index.php';
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$sql = "SELECT * FROM talleres";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Talleres</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .title-container {
            background-color: #fff;
            color: #333;
            padding: 20px;
            text-align: center;
            margin: 30px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 800px;
        }
        .title {
            font-size: 32px;
            margin: 0;
        }
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
            padding: 20px;
        }
        .card {
            width: 400px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            padding: 20px;
            margin: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
            color: #333;
        }
        .card-description {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }
        .location {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="title-container">
        <h1 class="title">Talleres Disponibles</h1>
    </div>
    <div class="card-container">
        <?php
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<h2 class="card-title">' . htmlspecialchars($fila['nombre']) . '</h2>';
                    echo '<p class="card-description">' . htmlspecialchars($fila['descripcion']) . '</p>';
                    echo '<p class="location">Ubicación: ' . htmlspecialchars($fila['direccion']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay talleres disponibles.</p>';
            }

            $resultado->free();
        } else {
            echo '<p>Error en la consulta: ' . $conn->error . '</p>';
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>

