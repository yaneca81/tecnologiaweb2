<?php
include 'index.php';
include 'includes\funciones.php';
$talleres = listarTalleres();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Talleres</title>
    <link rel="stylesheet" href="styles/lista.css">
    <link rel="stylesheet" href="styles/styles.css"> 
</head>
<body>
    <div class="list-container">
        <h1>Lista de Talleres Registrados</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Descripcion</th>
                    <th>Teléfono</th>
                    <th>Cupos Diarios</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($talleres as $taller): ?>
                    <tr>
                        <td><?php echo $taller['id_taller']; ?></td>
                        <td><?php echo htmlspecialchars($taller['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($taller['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($taller['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($taller['telefono'] ?? 'N/A'); ?></td>
                        <td><?php echo $taller['cupos_diarios']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
