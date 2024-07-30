<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleos Web App</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&family=Indie+Flower&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <img src="../assets/images/randall job.png" alt="Logo">
        <ul>
            <li><a href="../pages/index.php">Inicio</a></li>
            <li><a href="../pages/misPostulaciones.php">Mis Postulaciones</a></li>
            <li><a href="../pages/acercade.php">Acerca de</a></li>
            <?php if (isset($_COOKIE['user_id'])): ?>
                <li class="user-info">
                    <img src="<?php echo htmlspecialchars($_COOKIE['user_photo']); ?>" alt="User Photo">
                    <a href="perfil.php"><span><?php echo htmlspecialchars($_COOKIE['user_name']); ?></span></a>
                    <a href="../logic/logout.php">Cerrar Sesión</a>
                </li>
            <?php else: ?>
                <li><a href="../pages/login.php">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </header>
