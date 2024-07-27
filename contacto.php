<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto - Anuncios de Empleo</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Anuncios de Empleo</div>
            <ul>
                <li><a href="index.php">Inicio</a></li>
               
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="sobre_nosotros.php">Sobre Nosotros</a></li>
                <li><a href="usuario/login.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="formulario">
            <h1>Contacto</h1>
            <form action="procesar_contacto.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" required></textarea>
                
                <button type="submit" class="btn">Enviar</button>
            </form>
        </section>
    </main>
    <br><br><br>
     <?php
        include("footer.php");
     ?>
</body>
</html>
