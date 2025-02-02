<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../node_modules/animate.css/animate.min.css">
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var toggleButton = document.getElementById('togglePassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.textContent = 'Ocultar';
            } else {
                passwordField.type = 'password';
                toggleButton.textContent = 'Mostrar';
            }
        }
    </script>
</head>
<body class="animate__animated animate__fadeIn">
    <header>
        <nav>
            <div class="logo">Ingresa con tu cuenta</div>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../contacto.php">Contacto</a></li>
                <li><a href="../sobre_nosotros.php">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="formulario">
            <h1>Iniciar Sesión</h1>
            <form action="procesar_login.php" method="post">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <div id="error-email" style="color:red;"><?= $errores['email'] ?? '' ?></div>
                
                <label for="password">Contraseña:</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" style="width: calc(100% - 100px);">
                    <button type="button" id="togglePassword" onclick="togglePasswordVisibility()" style="width: 80px; position: absolute; right: 1; ">Mostrar</button>
                </div>
                <div id="error-password" style="color:red;"><?= $errores['password'] ?? '' ?></div>
                
                <button type="submit" class="btn">Iniciar Sesión</button>
            </form>
            <p>¿No tienes una cuenta? <a href="registro.php?rol=usuario">Regístrate</a></p>
        </section>
    </main>
    <br><br><br><br>
    <?php include("../footer.php"); ?>
</body>
</html>
