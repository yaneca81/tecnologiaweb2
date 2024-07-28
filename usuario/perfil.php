<?php
include '../includes/conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit();
}

//? Obtener la información del usuario
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id='$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $nombre = $usuario['nombre'];
    $email = $usuario['email'];
    $estado = $usuario['estado'];
    $imagen = $usuario['imagen'];
} else {
    echo "Usuario no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/perfil.css">
    <script src="../js/perfil.js" defer></script>   
</head>
<body>
    <header>
        <nav>
            <div class="logo">Anuncios de Empleo</div>
            <ul>
                <li><a href="dashboard_usuario.php">Inicio</a></li>
                <li><a href="postulaciones.php">Postulaciones</a></li>
                <li><a href="logout.php" id="logout-link">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="perfil">
            <h1>Perfil de Usuario</h1>
            <img src="../imagenes/<?php echo htmlspecialchars($imagen); ?>" alt="Foto de Perfil">
            <form action="procesar_perfil.php" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                
                <label for="password">Contraseña:</label>
                <div class="password-container">
                    <input type="password" id="password" name="password">
                    <button type="button" id="togglePassword" onclick="togglePasswordVisibility()">Mostrar</button>
                </div>
                
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="Estudiante" <?php if ($estado === 'Estudiante') echo 'selected'; ?>>Estudiante</option>
                    <option value="Egresado" <?php if ($estado === 'Egresado') echo 'selected'; ?>>Egresado</option>
                </select>
                
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen">
                
                <button type="submit">Actualizar Perfil</button>
            </form>
        </div>
    </main>
    
    <?php include("../footer.php"); ?>
</body>
</html>
