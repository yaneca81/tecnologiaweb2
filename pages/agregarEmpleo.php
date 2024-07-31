<?php
include '../includes/header_admin.php';
include '../logic/empleosAdminLogic.php';

$categorias = ['Tecnología', 'Salud', 'Educación', 'Administración', 'Comercio'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $categoria = trim($_POST['categoria']);
    $foto = $_FILES['foto'];

    $errors = [];

    if (empty($titulo) || strlen($titulo) > 20) {
        $errors['titulo'] = "El título es obligatorio y no debe exceder los 20 caracteres.";
    }
    if (empty($descripcion) || strlen($descripcion) > 50) {
        $errors['descripcion'] = "La descripción es obligatoria y no debe exceder los 50 caracteres.";
    }
    if (empty($categoria) || !in_array($categoria, $categorias)) {
        $errors['categoria'] = "La categoría es obligatoria.";
    }

    $fotoPath = '../uploads/empleos/sinFondo.jpg';
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
        if (agregarEmpleo($titulo, $descripcion, $categoria, $fotoPath)) {
            header('Location: empleosAdmin.php');
            exit();
        } else {
            $errors['general'] = "Error al agregar el empleo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Empleo</title>
    <link rel="stylesheet" href="../assets/css/error.css">
    <link rel="stylesheet" href="../assets/css/agregarEmpleo.css">
</head>
<body>
<main>
    <div class="form-container">
        <h2 class="titulo">Agregar Empleo</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : ''; ?>" required>
            <?php if (isset($errors['titulo'])): ?><div class="error"><?php echo $errors['titulo']; ?></div><?php endif; ?>

            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : ''; ?>" required>
            <?php if (isset($errors['descripcion'])): ?><div class="error"><?php echo $errors['descripcion']; ?></div><?php endif; ?>

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat; ?>" <?php echo isset($_POST['categoria']) && $_POST['categoria'] == $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['categoria'])): ?><div class="error"><?php echo $errors['categoria']; ?></div><?php endif; ?>

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto">
            <?php if (isset($errors['foto'])): ?><div class="error"><?php echo $errors['foto']; ?></div><?php endif; ?>

            <button type="submit">Agregar Empleo</button>
            <?php if (isset($errors['general'])): ?><div class="error"><?php echo $errors['general']; ?></div><?php endif; ?>
        </form>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
</body>
</html>