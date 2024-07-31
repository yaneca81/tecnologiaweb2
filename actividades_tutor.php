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

<footer>
    <p>&copy; 2024 Escuela ABC. Todos los derechos reservados.</p>
</footer>
</body>
</html>
