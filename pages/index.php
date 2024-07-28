<?php include '../config/config.php'; ?>
<?php include '../includes/header.php'; ?>

<main>
    <h2>Listado de Empleos</h2>
    <ul>
        <?php
        $sql = "SELECT * FROM empleo WHERE estado = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li>{$row['titulo']} - {$row['descripcion']}</li>";
            }
        } else {
            echo "<li>No hay empleos disponibles.</li>";
        }
        ?>
    </ul>
</main>

<?php include '../includes/footer.php'; ?>
