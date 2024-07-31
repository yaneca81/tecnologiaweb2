<?php
    require('../includes/conexion.php');
    session_start();
    $conn = Conectar();
    // Consulta para obtener todos los usuarios con su perfil
    $sql = "SELECT usuario.ID_Usuario AS UserID, usuario.Usuario AS NombreUsuario, perfil.Nombre AS NombreCompleto, perfil.Imagen AS ImagenPerfil
            FROM usuario JOIN perfil ON usuario.IDPerfil = perfil.ID";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/estilo-lista.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Portafolios Disponibles</title>
</head>
<body>
    <img src="../assets/images/portafolio/banner-lista.jpg" alt="Encabezado" class="header-image">
    <div class="card-container">
        <?php
        if ($result->num_rows > 0) 
        {
            // Mostrar los datos de los usuarios
            while ($row = $result->fetch_assoc()) 
            {
                // Convertir la imagen de perfil a base64
                $imgData = base64_encode($row["ImagenPerfil"]);
                ?>
                <div class="card">
                    <div class="card-header">
                        <img src="../assets/images/portafolio/icon-pin.png" alt="Icono de pin" class="icon-pin">
                        <h3 class="card-header-text">Visita el perfil</h3>
                    </div>
                    <img src="data:image/jpeg;base64,<?php echo $imgData; ?>" alt="Imagen del Desarrollador" class="card-image">
                    <div class="card-content">
                        <h2 class="card-title"><?php echo htmlspecialchars($row["NombreCompleto"]); ?></h2>
                        <a href="guardar.php?id=<?php echo $row['UserID']; ?>" class="card-button">
                            <i class="fa-solid fa-magnifying-glass"></i> Ver
                        </a>
                    </div>
                </div>
                <?php
            }
        } 
        else 
        {
            echo "<p>No se encontraron usuarios.</p>";
        }
        ?>
    </div>
    <div class="cont-but">
        <a href="../index.php" class="card-but"><i class="fa-solid fa-arrow-rotate-left"></i> Atrás</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>