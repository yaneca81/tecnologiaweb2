<?php include 'includes/conexion.php'; ?>
<?php include 'index.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones de Registro</title>
    <link rel="stylesheet" href="estilos/style.css">
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
        .description {
            text-align: center;
            font-size: 20px;
            color: #333;
            margin-bottom: 40px;
        }
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            padding: 0 20px;
        }
        .card {
            width: 350px;
            height: 250px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        .card-description {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }
        .card a {
            text-decoration: none;
            color: #fff;
            background-color: #555;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .card a:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="title-container">
        <h1 class="title">Opciones de Registro</h1>
    </div>
    <div class="description">Seleccione una opción para continuar con el registro.</div>
    <div class="card-container">
        <div class="card">
            <h2 class="card-title">Registrar Vehículo</h2>
            <p class="card-description">Acceda al formulario para registrar un nuevo vehículo en nuestro sistema.</p>
            <a href="registrar_vehiculo.php">Ir al formulario</a>
        </div>
        <div class="card">
            <h2 class="card-title">Registrar Cupo</h2>
            <p class="card-description">Acceda al formulario para registrar un nuevo cupo en el taller.</p>
            <a href="registrar_cupo.php">Ir al formulario</a>
        </div>
    </div>
</body>
</html>
