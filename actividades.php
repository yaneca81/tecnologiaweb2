<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas - Plataforma Escolar</title>
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
    <h1>Gestión de Tareas</h1>
    
    <!-- Formulario para agregar una nueva tarea -->
    <form action="agregar_tarea.php" method="post">
        <label for="titulo">Título de la tarea:</label>
        <input type="text" id="titulo" name="titulo" required>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required>
        
        <label for="fecha_final">Fecha Final:</label>
        <input type="datetime-local" id="fecha_final" name="fecha_final" required>
        
        <label for="profesor">Profesor:</label>
        <input type="text" id="profesor" name="profesor" required>
        
        <label for="materia">Materia:</label>
        <input type="text" id="materia" name="materia" required>
        
        <input type="submit" value="Agregar Tarea">
    </form>
    
    <main>
    <h2>Tareas Programadas</h2>
    <table>
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha Inicio</th>
            <th>Fecha Final</th>
            <th>Profesor</th>
            <th>Materia</th>
        </tr>
        <?php
        require 'includes/conexion.php'; // Asegúrate de tener la conexión a la base de datos

        function obtenerTareas() {
            $conn = conectar(); // Conectar a la base de datos
            $sql = "SELECT Titulo, Descripcion, Fecha_inicio, Fecha_presentacion, CONCAT(p.Nombre, ' ', p.Apellido) AS Profesor, m.Nombre AS Materia
                    FROM Tarea t
                    JOIN Profesor pr ON t.Id_profesor = pr.Id
                    JOIN Persona p ON pr.Id_persona = p.Id
                    JOIN Materia m ON t.Id_materia = m.Id";
            $resultado = mysqli_query($conn, $sql);
            $tareas = [];
            if ($resultado) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $tareas[] = $fila;
                }
                mysqli_free_result($resultado);
            } else {
                echo "Error en la consulta: " . mysqli_error($conn);
            }
            mysqli_close($conn);
            return $tareas;
        }

        $tareas = obtenerTareas();

        foreach ($tareas as $tarea) {
            echo "<tr>";
            echo "<td>{$tarea['Titulo']}</td>";
            echo "<td>{$tarea['Descripcion']}</td>";
            echo "<td>{$tarea['Fecha_inicio']}</td>";
            echo "<td>{$tarea['Fecha_presentacion']}</td>";
            echo "<td>{$tarea['Profesor']}</td>";
            echo "<td>{$tarea['Materia']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</main>
</main>
<footer>
    <p>&copy; 2024 Escuela ABC. Todos los derechos reservados.</p>
</footer>
</body>
</html>
