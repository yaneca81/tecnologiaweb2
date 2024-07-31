<?php
require 'includes/funciones.php'; // Asegúrate de que esta ruta sea correcta

// Verifica si la función 'obtenerCalificaciones' existe
if (!function_exists('obtenerCalificaciones')) {
    die('La función obtenerCalificaciones no está definida en funciones.php');
}

// Obtener calificaciones desde la base de datos
$calificaciones = obtenerCalificaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones - Plataforma Escolar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="escuela.png" alt="Logo de la Escuela">
            <nav>
                <ul>
                    <li><a href="index_encargados.php">Inicio</a></li>
                    <li><a href="actividades.php">Actividades</a></li>
                    <li><a href="reuniones.php">Reuniones</a></li>
                    <li><a href="calificaciones.php">Calificaciones</a></li>
                    <div class="logout">
                        <a href="login.php" class="button">Cerrar Sesión</a>
                    </div>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <h1>Gestión de Calificaciones</h1>
        
        <!-- Formulario para registrar calificaciones -->
        <form action="registrar_calificacion.php" method="post">
        <label for="fecha_inicio">Fecha de calificacion:</label>
        <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required>            
            <label for="calificacion">Calificación:</label>
            <input type="number" id="calificacion" name="calificacion" min="0" max="100" required>
            <label for="materia">Tarea:</label>
            <input type="text" id="materia" name="materia" required>
            <input type="submit" value="Registrar Calificación">
        </form>
        
        <!-- Lista de calificaciones -->
        <h2>Calificaciones Registradas</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Nota</th>
                <th>Tarea</th>
            </tr>
            <!-- Mostrar las calificaciones desde el servidor -->
            <?php
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
