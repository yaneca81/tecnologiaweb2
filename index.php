<?php
include_once 'incluye/parciales/cabecera.php';
include_once 'incluye/funciones.php';
$ofertas = obtenerOfertas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ofertas de Trabajo</title>
    
</head>
<body>
    <h1>Ofertas de Trabajo</h1>
    <?php if (empty($ofertas)): ?>
        <p>No hay ofertas disponibles.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($ofertas as $oferta): ?>
                <li>
                    <h2><?php echo htmlspecialchars($oferta['titulo']); ?></h2>
                    <p><?php echo htmlspecialchars($oferta['descripcion']); ?></p>
                    <p>Requisitos: <?php echo htmlspecialchars($oferta['requisitos']); ?></p>
                    <p>Salario: <?php echo htmlspecialchars($oferta['salario']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>

<?php
include 'incluye/parciales/pie.php';
?>
