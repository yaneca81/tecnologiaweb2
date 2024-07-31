<?php

$rol_usuario = isset($_SESSION['usuario_id']) ? obtenerRolUsuario($_SESSION['usuario_id']) : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <link rel="stylesheet" href="../src/css/estilo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        header nav ul li {
            margin: 0 15px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        main {
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }

        .ofertas {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .oferta {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            width: calc(33.333% - 20px);
            box-sizing: border-box;
        }

        .oferta h2 {
            margin-top: 0;
        }

        .auth-links {
            text-align: center;
            margin-top: 20px;
        }

        .auth-links a {
            text-decoration: none;
            color: #007bff;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        footer {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../candidatos/index.php">Ofertas de Trabajo</a></li>
                <li><a href="../candidatos/entrevistas.php">Entrevistas</a></li>
                <li><a href="../autentificacion/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
    </main>
    <footer>
        &copy; <?php echo date("Y"); ?> Mi Aplicación
    </footer>
</body>
</html>
