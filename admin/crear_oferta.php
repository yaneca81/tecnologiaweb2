<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Oferta</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/crear_oferta.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/modal_crear_oferta.css">
<style>
    .error{
        color: red;
    }
</style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Panel de Administrador</div>
            <ul>
                <li><a href="dashboard_admin.php">Inicio</a></li>
                <li><a href="crear_oferta.php">Crear Oferta</a></li>
                <li><a href="ver_ofertas.php">Ver Ofertas</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="formulario">
            <h1>Crear Nueva Practica Profesional</h1>
            <?php if (!empty($errores['general'])): ?>
                <div class="error"><?php echo htmlspecialchars($errores['general']); ?></div>
            <?php endif; ?>
            <form action="procesar_crear_oferta.php" method="post" enctype="multipart/form-data">
                <label for="titulo">Título de la Oferta:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo ?? ''); ?>">
                <?php if (!empty($errores['titulo'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errores['titulo']); ?></div>
                <?php endif; ?>
                
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($descripcion ?? ''); ?></textarea>
                <?php if (!empty($errores['descripcion'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errores['descripcion']); ?></div>
                <?php endif; ?>
                
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria">
                    <option value="">Seleccione una categoría</option>
                    <option value="Estudiante" <?php echo ($categoria ?? '') == 'Estudiante' ? 'selected' : ''; ?>>Estudiante</option>
                    <option value="Egresado" <?php echo ($categoria ?? '') == 'Egresado' ? 'selected' : ''; ?>>Egresado</option>
                </select>
                <?php if (!empty($errores['categoria'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errores['categoria']); ?></div>
                <?php endif; ?>
                
                <label for="empresa">Nombre de la Empresa:</label>
                <input type="text" id="empresa" name="empresa" value="<?php echo htmlspecialchars($empresa ?? ''); ?>">
                <?php if (!empty($errores['empresa'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errores['empresa']); ?></div>
                <?php endif; ?>
                
                <label for="contacto">Correo de Contacto:</label>
                <input type="email" id="contacto" name="contacto" value="<?php echo htmlspecialchars($email_contacto ?? ''); ?>">
                <?php if (!empty($errores['contacto'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errores['contacto']); ?></div>
                <?php endif; ?>
                
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen">
                <?php if (!empty($errores['imagen'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errores['imagen']); ?></div>
                <?php endif; ?>
                
                <button type="submit" class="btn">Crear Oferta</button>
            </form>
        </section>
    </main>
    <footer>
        <div class="container-footer">
            <div class="row">
                <div class="col-md-4">
                    <p>Busca tu práctica profesional y aviéntate a la vida laboral</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Todos los derechos Reservados by Grupo 7 © 2024 </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Ventana Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>¡La oferta se ha registrado con éxito!</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
                var modal = document.getElementById('successModal');
                var span = document.getElementsByClassName('close')[0];

                modal.style.display = 'block';

                span.onclick = function() {
                    modal.style.display = 'none';
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                }
            <?php endif; ?>
        });
    </script>
</body>
</html>
