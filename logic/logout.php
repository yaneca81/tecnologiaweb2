<?php
// Eliminar cookies
setcookie("user_id", "", time() - 3600, "/");
setcookie("user_name", "", time() - 3600, "/");
setcookie("user_role", "", time() - 3600, "/");
setcookie("user_photo", "", time() - 3600, "/");

// Redirigir a la página de inicio
header('Location: ../pages/index.php');
exit();
?>
