<?php
if (!isset($_COOKIE['user_id']) || $_COOKIE['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/header_admin.css">
    <script src="../assets/js/header_admin.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&family=Indie+Flower&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="admin-header">
        <button id="menuToggle" class="menu-toggle">&#9776;</button>
        <div class="header-center">
            <img src="../assets/images/randall job.png" alt="Logo" class="logo">
            <a href="../pages/dashboard.php"><h1 class="tituloEmpresa">Randall Job</h1></a>
        </div>
        <div class="user-info">
            <img src="<?php echo htmlspecialchars($_COOKIE['user_photo']); ?>" alt="User Photo">
            <a href="perfil.php"><?php echo htmlspecialchars($_COOKIE['user_name']); ?></a>
            <a href="../logic/logout.php">Cerrar Sesión</a>
        </div>
    </header>
    <nav id="sidebar" class="sidebar">
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="../pages/empleosAdmin.php">Empleos</a></li>
            <li><a href="../pages/usuarioAdmin.php">Usuarios</a></li>
            <li><a href="postulaciones.php">Postulaciones</a></li>
        </ul>
    </nav>
</body>
</html>