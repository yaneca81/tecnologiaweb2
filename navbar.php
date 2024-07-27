<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Prácticas Profesionales</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Anuncios de Practicas</div>
            <ul>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="sobre_nosotros.php">Sobre Nosotros</a></li>
                <li><a href="usuario/login.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <div class="contenido-hero">
                <h1>Bienvenido al Sistema de Prácticas Profesionales</h1>
                <p>Encuentra tu practica ¡ya!</p>
                <div class="botones-hero">
                    <a href="usuario/login.php" class="btn">Buscar practica</a>
                </div>
            </div>
        </section>
        <section class="caracteristicas">
            <div class="caracteristica">
                <h2>Fácil de Usar</h2>
                <p>Encuentra ofertas de empresas para practicantes.</p>
            </div>
            <div class="caracteristica">
                <h2>Categorías Variadas</h2>
                <p>Ofertas para estudiantes o egresados.</p>
            </div>
            <div class="caracteristica">
                <h2>Soporte 24/7</h2>
                <p>Estamos disponibles para ayudarte en cualquier momento.</p>
            </div>
        </section>
    </main>

    <?php
    include("footer.php");
    ?>
</body>
</html>
