<?php
require_once 'model/TipoModel.php';
$id = $_GET['id'] ?? null;

$typeModel = new TipoModel();

$types = $typeModel->get();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');


    $requiredFields = ['nombre', 'descripcion'];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Este campo es obligatorio';
        }
    }

    if (!empty($nombre)) {
        if (strlen($nombre) < 3) {
            $errors['nombre'] = 'El nombre debe tener al menos 3 caracteres';
        } elseif (strlen($nombre) > 300) {
            $errors['nombre'] = 'El nombre no puede tener más de 300 caracteres';
        }
    }

    if (!empty($descripcion)) {
        if (strlen($descripcion) < 10) {
            $errors['descripcion'] = 'La descripción debe tener al menos 10 caracteres';
        } elseif (strlen($descripcion) > 300) {
            $errors['descripcion'] = 'La descripción no puede tener más de 300 caracteres';
        }
    }


    if (empty($errors)) {
        if (!$id) {
            $idTipo =  $typeModel->create([
                'nombre' => $nombre,
                'descripcion' => $descripcion
            ]);
        } else {
            $typeModel->update($id, [
                'nombre' => $nombre,
                'descripcion' => $descripcion
            ]);
        }


        header('Location: ' . BASE_URL . '/admin/tipos.php');
    }
} else {
    if ($id) {
        $property = $typeModel->find($id);

        $_POST['nombre'] = $property['nombre'];
        $_POST['descripcion'] = $property['descripcion'];
    }
}


function getError($field)
{
    global $errors;
    return isset($errors[$field]) ? $errors[$field] : '';
}
?>


<?php include 'view/admin/layout/header.php' ?>

<div class="card container">
    <div class="card-body">
        <h1 class="mb-4">Crear Tipo</h1>


        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-3">

                <div class="col-12">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control <?php echo !empty(getError('nombre')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('nombre'); ?></div>
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" class="form-control <?php echo !empty(getError('descripcion')) ? 'is-invalid' : ''; ?>" "  rows=" 3"><?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?></textarea>
                    <div class="invalid-feedback"><?php echo getError('descripcion'); ?></div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary">Crear Tipo</button>
                </div>
            </div>
        </form>

    </div>
</div>


<?php include 'view/admin/layout/footer.php' ?>