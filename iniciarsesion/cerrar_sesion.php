<?php
session_start();
session_destroy(); // Destruye todas las sesiones
header('Location: login.php'); // Redirige al usuario a la página de inicio de sesión
exit();
?>
