<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleos Web App</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <style>
        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px;
        }
        .navbar ul {
            list-style-type: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }
        .navbar li {
            display: flex;
            align-items: center;
        }
        .navbar img {
            height: 40px;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
        }
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar .user-info img {
            height: 40px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <img src="/assets/images/logo.png" alt="Logo">
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/pages/postulaciones.php">Postulaciones</a></li>
            <li><a href="/pages/acerca.php">Acerca de</a></li>
            <?php if (isset($_COOKIE['user_id'])): ?>
                <li class="user-info">
                    <img src="<?php echo htmlspecialchars($_COOKIE['user_photo']); ?>" alt="User Photo">
                    <span><?php echo htmlspecialchars($_COOKIE['user_name']); ?></span>
                    <a href="/pages/logout.php">Cerrar Sesión</a>
                </li>
            <?php else: ?>
                <li><a href="/pages/login.php">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </header>
