<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Plataforma de Mantenimiento Vehicular</title>
    <link rel="stylesheet" href="estilos/style.css">
</head>
<body>
    <main>
        <section class="registro-form">
            <h2>Registro de Usuario</h2>
            <?php
            if (isset($_GET['success'])) {
                echo '<p class="success-message">Registro exitoso. Puedes iniciar sesión ahora.</p>';
            }
            ?>
            <form action="procesar_registro.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono">

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <label for="tipo_usuario">Tipo de Usuario:</label>
                <select id="tipo_usuario" name="tipo_usuario" required>
                    <option value="cliente">Cliente</option>
                    <option value="administrador">Administrador</option>
                </select>

                <button type="submit">Registrarse</button>
            </form>
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 TURBOGARAGEMONKEY. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

