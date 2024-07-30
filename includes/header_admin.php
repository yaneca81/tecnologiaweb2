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
</head>
<body>
    <header class="admin-header">
        <button id="menuToggle" class="menu-toggle">&#9776;</button>
        <div class="header-center">
            <img src="../assets/images/logo-sin-fondo.png" alt="Logo" class="logo">
            <a href="../pages/dashboard.php"><h1>Randall Job</h1></a>
        </div>
        <div class="user-info">
            <a href="perfil.php"><?php echo htmlspecialchars($_COOKIE['user_name']); ?></a>
            <img src="<?php echo htmlspecialchars($_COOKIE['user_photo']); ?>" alt="User Photo">
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
