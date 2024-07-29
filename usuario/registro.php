<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/modal_registro_usuario.css">
   
   
</head>
<body>
    <header>
        <nav>
            <div class="logo">Anuncios de Empleo</div>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../contacto.php">Contacto</a></li>
                <li><a href="../sobre_nosotros.php">Sobre Nosotros</a></li>
                <li><a href="login.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="formulario">
            <h1>Registro de Usuario</h1>
            <div id="mensaje" style="display:none; color: green; font-weight: bold;"></div>
            <form id="registroForm" action="procesar_registro.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="rol" value="usuario">
                
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                <div id="error-nombre" style="color:red;"><?= $errores['nombre'] ?? '' ?></div>
                
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <div id="error-email" style="color:red;"><?= $errores['email'] ?? '' ?></div>
                
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password">
                <div id="error-password" style="color:red;"><?= $errores['password'] ?? '' ?></div>
                
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="Estudiante" <?= (isset($_POST['estado']) && $_POST['estado'] === 'Estudiante') ? 'selected' : '' ?>>Estudiante</option>
                    <option value="Egresado" <?= (isset($_POST['estado']) && $_POST['estado'] === 'Egresado') ? 'selected' : '' ?>>Egresado</option>
                </select>
                <div id="error-estado" style="color:red;"><?= $errores['estado'] ?? '' ?></div>
                
                <label for="imagen">Foto Perfil:</label>
                <input type="file" id="imagen" name="imagen">
                
                <button type="submit" class="btn">Registrarse</button>
            </form>
        </section>
    </main>
   
    <?php include("../footer.php"); ?>

    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalMensaje"></p>
        </div>
    </div>

    <script>
        function mostrarMensaje(mensaje) {
            var modal = document.getElementById('successModal');
            var mensajeDiv = document.getElementById('modalMensaje');
            mensajeDiv.innerText = mensaje;
            modal.style.display = 'block';
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 1000);
        }
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
                mostrarMensaje('Registro exitoso. Redirigiendo a inicio de sesión...');
            <?php endif; ?>
        });
    </script>
</body>
</html>
