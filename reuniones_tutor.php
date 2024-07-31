<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reuniones - Plataforma Escolar</title>
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
        <h2>Reuniones Programadas</h2>
        <table>
            <tr>
                <th>Tema</th>
                <th>Fecha y Hora</th>
            </tr>
            <?php
            require 'includes/conexion.php'; // Asegúrate de tener la conexión a la base de datos

            function obtenerReuniones() {
                $conn = conectar(); // Conectar a la base de datos
                $sql = "SELECT Titulo, CONCAT(Fecha, ' ', Hora) AS FechaHora FROM Reunion";
                $resultado = mysqli_query($conn, $sql);
                $reuniones = [];
                if ($resultado) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        $reuniones[] = $fila;
                    }
                    mysqli_free_result($resultado);
                } else {
                    echo "Error en la consulta: " . mysqli_error($conn);
                }
                mysqli_close($conn);
                return $reuniones;
            }

            $reuniones = obtenerReuniones();

            foreach ($reuniones as $reunion) {
                echo "<tr>";
                echo "<td>{$reunion['Titulo']}</td>";
                echo "<td>{$reunion['FechaHora']}</td>";
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
