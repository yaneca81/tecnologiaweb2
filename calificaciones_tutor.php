<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificaciones - Plataforma Escolar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="escuela.png" alt="Logo de la Escuela">
            <nav>
                <ul>
                    <li><a href="index_tutor.php">Inicio</a></li>
                    <li><a href="actividades_tutor.php">Actividades</a></li>
                    <li><a href="reuniones_tutor.php">Reuniones</a></li>
                    <li><a href="calificaciones_tutor.php">Calificaciones</a></li>
                    <li><a></a></li>
                    <li><a></a></li>
                    <div class="logout">
            <a href="login.php" class="button">Cerrar Sesión</a>
        </div>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <!-- Lista de calificaciones -->
        <h2>Calificaciones Registradas</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Nota</th>
                <th>Tarea</th>
               
            </tr>
            <!-- Aquí se mostrarán las calificaciones desde el servidor -->
            <?php
            require 'includes/funciones.php'; // Incluye el archivo con la función

            $calificaciones = obtenerCalificaciones(); // Llama a la función
            
            foreach ($calificaciones as $calificacion) {
                echo "<tr>";
                echo "<td>{$calificacion['ID']}</td>";
                echo "<td>{$calificacion['Fecha']}</td>";
                echo "<td>{$calificacion['Nota']}</td>";
                echo "<td>{$calificacion['Tarea']}</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Escuela ABC. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
