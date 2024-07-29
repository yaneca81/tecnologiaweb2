<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto - Prácticas Profesionales</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        
        nav ul {
            list-style: none;
            float: right;
            margin-right: 20px;
        }
        nav ul li {
            display: inline;
            margin-left: 20px;
        }
        nav ul li a {
            text-decoration: none;
        }
        main {
            text-align: center;
            padding: 20px;
            margin-bottom: 30px;
        }
        .tarjeta-contacto {
            height: 350px;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            width: 700px;
            background-color: #f9f9f9;
            margin-top: 90px;
        }
        .tarjeta-contacto h1 {
           margin-top: 10px; 
        }
        .tarjeta-contenido p {
            margin: 30px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Prácticas Profesionales</div>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="sobre_nosotros.php">Sobre Nosotros</a></li>
                <li><a href="usuario/login.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="tarjeta-contacto">
            <h1>Contacto</h1>
            <div class="tarjeta-contenido">
                <p><strong>Nombre de la Empresa:</strong> Prácticas Profesionales.</p>
                <p><strong>Dirección:</strong> Av. Los Sauces, esq. Fabián Ruiz</p>
                <p><strong>Correo Electrónico:</strong> infoupds.tarija@upds.edu.bo</p>
                <p><strong>Teléfono:</strong> (+591-4) 665-8303</p>
            </div>
        </section>
    </main>
    <br><br>
    <?php
        include("footer.php");
     ?>
</body>
</html>
