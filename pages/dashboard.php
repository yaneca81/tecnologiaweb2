<?php
include '../config/config.php';
include '../includes/header.php';

// Verificar si el usuario es admin
if (!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<main>
    <h2>Panel de Administración</h2>
    <!-- Contenido del dashboard -->
</main>
<?php include '../includes/footer.php'; ?>
