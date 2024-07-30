<?php
include '../config/config.php';
include '../includes/header.php';
include '../logic/empleoLogic.php';
$empleos = obtenerEmpleos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleos Web App - Home</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
</head>
<body>
<main>
    <h2>Listado de Empleos</h2>
    <div class="empleos-container">
        <?php if (count($empleos) > 0): ?>
            <?php foreach ($empleos as $empleo): ?>
                <div class='empleo'>
                    <img src='<?php echo $empleo['foto']; ?>' alt='<?php echo $empleo['titulo']; ?>'>
                    <h3><?php echo $empleo['titulo']; ?></h3>
                    <p><?php echo $empleo['descripcion']; ?></p>
                    <button onclick='postular(<?php echo $empleo["id"]; ?>)'>Postular</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay empleos disponibles.</p>
        <?php endif; ?>
    </div>
</main>

<!-- Modal para iniciar sesión -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Debe iniciar sesión para postularse.</p>
        <a href="login.php" class="button">Iniciar Sesión</a>
    </div>
</div>

<!-- Modal para postularse -->
<!--div id="postularModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="postulacionForm" method="POST" enctype="multipart/form-data">
            <h3 id="postularTitulo"></h3>
            <img id="postularFoto" src="" alt="Foto del empleo">
            <br>
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" maxlength="220" required></textarea>
            <div id="mensajeError" class="error"></div>
            <label for="archivo">Subir Currículum (PDF):</label>
            <input type="file" id="archivo" name="archivo" accept="application/pdf" required>
            <div id="archivoError" class="error"></div>
            <input type="hidden" id="empleoId" name="empleo_id">
            <button type="submit">Enviar Postulación</button>
        </form>
    </div>
</div-->

<script src="../assets/js/index.js"></script>

</body>
</html>

<?php include '../includes/footer.php'; ?>
