<?php
session_start(); // Iniciar la sesión para manejar variables de sesión

// Elimina todas las variables de sesión
$_SESSION = array();

// Si se utiliza una cookie de sesión, eliminarla también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruye la sesión
session_destroy();

// Redirigir al usuario a la página de inicio o inicio de sesión
header('Location: ../index.php');
exit();
?>
