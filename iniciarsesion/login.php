<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Plataforma de Mantenimiento Vehicular</title>
    <link rel="stylesheet" href="estilos/style.css">
</head>
<body>
    <main>
        <section class="login-form">
            <h2>Iniciar Sesión</h2>
            <?php
            if (isset($_GET['error'])) {
                echo '<p class="error-message">Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>';
            }
            ?>
            <form action="procesar_login.php" method="post">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <button type="submit">Iniciar Sesión</button>
            </form>
            <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </section>
    </main>
</body>
</html>
