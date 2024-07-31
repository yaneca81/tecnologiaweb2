<?php
    require('../includes/conexion.php');
    session_start();

    if (!isset($_SESSION['userID'])) 
    {
        echo "No estás autenticado. Redirigiendo...";
        header("Location: ../inicio.php");
        exit();
    }

    $userID = $_SESSION['userID'];
    $conn = Conectar();
    $sql = "SELECT * FROM mensaje WHERE id_usuario = ?";
    $datos = $conn->prepare($sql);
    $datos->bind_param("i", $userID);
    $datos->execute();
    $result = $datos->get_result();
    $mensajes = [];
    if ($result->num_rows > 0) 
    {
        while ($row = $result->fetch_assoc()) {
            $mensajes[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <title>Usuario | Mensajes</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/estilo-sms.css">
</head>
<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <div class="input-group">
                <img src="../assets/images/mensajes/icon-sms.png" alt="Icono de mensajes" />
                <h1>Mensajes</h1>
            </div>
            <div class="export__file">
                <label for="export-file" class="export__file-btn" title="Export File"></label>
                <span class="export__file-text"><a href="../usuario/inicio.php">Salir</a></span>
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Nombre </th>
                        <th> Correo </th>
                        <th> Mensajes </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mensajes)): ?>
                        <?php foreach ($mensajes as $mensaje): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($mensaje['Nombre']); ?></td>
                                <td><?php echo htmlspecialchars($mensaje['correo']); ?></td>
                                <td><?php echo htmlspecialchars($mensaje['mensaje']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                            <tr>
                                <td colspan="3">No se encontraron mensajes.</td>
                            </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
    <script src="../assets/scripts/sms.js"></script>

</body>

</html>
