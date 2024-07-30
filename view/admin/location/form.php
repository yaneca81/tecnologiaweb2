<?php
require_once 'model/LocationModel.php';
$id = $_GET['id'] ?? null;

$locationModel = new UbicacionModel();

$locations = $locationModel->get();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ciudad = trim($_POST['ciudad'] ?? '');
    $departamento = trim($_POST['departamento'] ?? '');
    $pais = trim($_POST['pais'] ?? '');
    $latitud = is_numeric($_POST['latitud']) ? (float)$_POST['latitud'] : '';
    $longitud = is_numeric($_POST['longitud']) ? (float)$_POST['longitud'] : '';

    $requiredFields = ['ciudad', 'departamento', 'pais', 'latitud', 'longitud'];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Este campo es obligatorio';
        }
    }

    if (!empty($ciudad)) {
        if (strlen($ciudad) < 5) {
            $errors['ciudad'] = 'La ciudad debe tener al menos 5 caracteres';
        } elseif (strlen($ciudad) > 300) {
            $errors['ciudad'] = 'La ciudad no puede tener más de 300 caracteres';
        }
    }

    if (!empty($departamento)) {
        if (strlen($departamento) < 5) {
            $errors['departamento'] = 'El departamento debe tener al menos 5 caracteres';
        } elseif (strlen($departamento) > 300) {
            $errors['departamento'] = 'El departamento no puede tener más de 300 caracteres';
        }
    }

    if (!empty($pais)) {
        if (strlen($pais) < 5) {
            $errors['pais'] = 'El pais debe tener al menos 5 caracteres';
        } elseif (strlen($pais) > 300) {
            $errors['pais'] = 'El pais no puede tener más de 300 caracteres';
        }
    }

    if (!empty($latitud)) {
        if (!is_numeric($latitud)) {
            $errors['latitud'] = 'El latitud debe ser un número';
        } elseif ($latitud < 0) {
            $errors['latitud'] = 'El latitud no puede ser negativo';
        }
    }


    if (!empty($longitud)) {
        if (!is_numeric($longitud)) {
            $errors['longitud'] = 'La longitud debe ser un número';
        } elseif ($longitud < 0) {
            $errors['longitud'] = 'La longitud no puede ser negativa';
        }
    }

    if (empty($errors)) {
        if (!$id) {
            $idUbicacion =  $locationModel->create([
                'ciudad' => $ciudad,
                'departamento' => $departamento,
                'pais' => $pais,
                'latitud' => $latitud,
                'longitud' => $longitud
            ]);
        } else {
            $locationModel->update($id, [
                'ciudad' => $ciudad,
                'departamento' => $departamento,
                'pais' => $pais,
                'latitud' => $latitud,
                'longitud' => $longitud
            ]);
        }

        header('Location: ' . BASE_URL . '/admin/ubicaciones.php');
    }
}else {
    if ($id) {
        $location = $locationModel->find($id);

        $_POST['ciudad'] = $location['ciudad'];
        $_POST['departamento'] = $location['departamento'];
        $_POST['pais'] = $location['pais'];
        $_POST['latitud'] = $location['latitud'];
        $_POST['longitud'] = $location['longitud'];
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
        <h1 class="mb-4">Crear Ubicación</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-12">
                    <label for="ciudad" class="form-label">Ciudad:</label>
                    <input type="text" name="ciudad" id="ciudad" class="form-control 
                    <?php echo !empty(getError('ciudad')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['ciudad']) ? $_POST['ciudad'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('ciudad'); ?></div>
                </div>

                <div class="col-12">
                    <label for="departamento" class="form-label">Departamento:</label>
                    <input type="text" name="departamento" id="departamento" class="form-control 
                    <?php echo !empty(getError('departamento')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['departamento']) ? $_POST['departamento'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('departamento'); ?></div>
                </div>

                <div class="col-12">
                    <label for="pais" class="form-label">País:</label>
                    <input type="text" name="pais" id="pais" class="form-control 
                    <?php echo !empty(getError('pais')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['pais']) ? $_POST['pais'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('pais'); ?></div>
                </div>

                <div class="col-md-6">
                    <label for="latitud" class="form-label">Latitud:</label>
                    <input type="number" name="latitud" id="latitud" class="form-control 
                    <?php echo !empty(getError('latitud')) ? 'is-invalid' : ''; ?>" step="0.01" value="<?php echo isset($_POST['latitud']) ? $_POST['latitud'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('latitud'); ?></div>
                </div>

                <div class="col-md-6">
                    <label for="longitud" class="form-label">Longitud:</label>
                    <input type="number" name="longitud" id="longitud" step="0.01" class="form-control 
                    <?php echo !empty(getError('longitud')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['longitud']) ? $_POST['longitud'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('longitud'); ?></div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary">Crear Ubicación</button>
                </div>
            </div>
        </form>

    </div>
</div>

<?php include 'view/admin/layout/footer.php' ?>