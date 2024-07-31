<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión - Plataforma Escolar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="escuela.png" alt="Logo de la Escuela">
        </div>
    </header>
    <main>
        <h1>Inicio de Sesión</h1>
        <form action="procesar_login.php" method="post">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <br>
            <input type="submit" value="Iniciar Sesión">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Escuela ABC. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
