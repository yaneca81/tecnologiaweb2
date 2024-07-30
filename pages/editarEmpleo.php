<?php
include '../includes/header_admin.php';
include '../logic/empleosAdminLogic.php';

if (!isset($_GET['id'])) {
    header('Location: empleosAdmin.php');
    exit();
}

$id = $_GET['id'];
$empleo = null;

$empleos = obtenerEmpleosAdmin();
foreach ($empleos as $e) {
    if ($e['id'] == $id) {
        $empleo = $e;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $categoria = trim($_POST['categoria']);
    $foto = $_FILES['foto'];

    $errors = [];

    if (strlen($titulo) > 20) {
        $errors['titulo'] = "El título no debe exceder los 20 caracteres.";
    }
    if (strlen($descripcion) > 50) {
        $errors['descripcion'] = "La descripción no debe exceder los 50 caracteres.";
    }
    if (strlen($categoria) > 20) {
        $errors['categoria'] = "La categoría no debe exceder los 20 caracteres.";
    }

    $fotoPath = $empleo['foto'];
    if (!empty($foto['tmp_name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($foto['type'], $allowedTypes)) {
            $errors['foto'] = "El archivo debe ser una imagen (jpeg, png, jpg).";
        } else {
            $fotoPath = '../uploads/empleos/' . basename($foto['name']);
            if (!move_uploaded_file($foto['tmp_name'], $fotoPath)) {
                $errors['foto'] = "Error al subir la imagen.";
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE empleo SET titulo = ?, descripcion = ?, categoria = ?, foto = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $titulo, $descripcion, $categoria, $fotoPath, $id);
        if ($stmt->execute()) {
            header('Location: empleosAdmin.php');
            exit();
        } else {
            $errors['general'] = "Error al actualizar el empleo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleo</title>
    <link rel="stylesheet" href="../assets/css/error.css">
    <link rel="stylesheet" href="../assets/css/editarEmpleo.css">
</head>
<body>
<main>
    <h2>Editar Empleo</h2>
    <?php if ($empleo): ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($empleo['titulo']); ?>" required>
            <?php if (isset($errors['titulo'])): ?><div class="error"><?php echo $errors['titulo']; ?></div><?php endif; ?>

            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($empleo['descripcion']); ?>" required>
            <?php if (isset($errors['descripcion'])): ?><div class="error"><?php echo $errors['descripcion']; ?></div><?php endif; ?>

            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($empleo['categoria']); ?>" required>
            <?php if (isset($errors['categoria'])): ?><div class="error"><?php echo $errors['categoria']; ?></div><?php endif; ?>

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto">
            <?php if (isset($errors['foto'])): ?><div class="error"><?php echo $errors['foto']; ?></div><?php endif; ?>

            <button type="submit">Actualizar Empleo</button>
            <?php if (isset($errors['general'])): ?><div class="error"><?php echo $errors['general']; ?></div><?php endif; ?>
        </form>
    <?php else: ?>
        <p>Empleo no encontrado.</p>
    <?php endif; ?>
</main>
</body>
</html>

<?php include '../includes/footer.php'; ?>
