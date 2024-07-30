<?php
require_once 'model/UserModel.php';
$id = $_GET['id'] ?? null;

$userModel = new UserModel();

$users = $userModel->get();

$errors = [];

function repeatedEmail($email)
{
    global $users;
    $isRepeated = false;
    foreach ($users as $key => $usuario) {
        if ($usuario['correo'] == $email) {
            $isRepeated = true;
        }
    }
    return $isRepeated;
}

function isValidPassword($password)
{
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';

    $hasLetter = false;
    $hasNumber = false;

    for ($i = 0; $i < strlen($password); $i++) {
        if (strpos($letters, $password[$i]) !== false) {
            $hasLetter = true;
        }
        if (strpos($numbers, $password[$i]) !== false) {
            $hasNumber = true;
        }
    }

    return $hasLetter && $hasNumber;
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST["nombre"] ?? '';
    $correo = $_POST["correo"] ?? '';
    $contrasena = $_POST["contrasena"] ?? '';

    if (empty($nombre)) {
        $errors['nombre'] = "El nombre es obligatorio.";
    } elseif (strlen($nombre) < 5) {
        $errors['nombre'] = "El nombre debe tener al menos 5 caracteres.";
    } else if (strlen($nombre) > 50) {
        $errors['nombre'] = "El nombre no debe tener más de 50 caracteres.";
    }

    if (!$id) {
        if (empty($correo)) {
            $errors['correo'] = "El correo es obligatorio.";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errors['correo'] = "El correo no es válido.";
        } elseif (repeatedEmail($correo)) {
            $errors['correo'] = "El correo ingresado ya se encuentra en uso.";
        }
    } else {
        if (empty($correo)) {
            $errors['correo'] = "El correo es obligatorio.";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errors['correo'] = "El correo no es válido.";
        }
    }
    

    if (empty($contrasena)) {
        $errors['contrasena'] = "La contraseña es obligatoria.";
    } elseif (strlen($contrasena) < 4) {
        $errors['contrasena'] = "La contraseña debe tener al menos 4 caracteres.";
    } elseif (strlen($contrasena) > 40) {
        $errors['contrasena'] = "La contraseña  no debe tener más de 40 caracteres.";
    } elseif (!isValidPassword($contrasena)) {
        $errors['contrasena'] = "La contraseña debe incluir al menos una letra y un número.";
    }

    if (empty($errors)) {
        if (!$id) {
            $userModel->create([
                'nombre' => $nombre,
                'correo' => $correo,
                'contrasena' => password_hash($contrasena, PASSWORD_DEFAULT)
            ]);
        } else {
            $userModel->update($id, [
                'nombre' => $nombre,
                'correo' => $correo,
                'contrasena' => password_hash($contrasena, PASSWORD_DEFAULT)
            ]);
        }
        header('Location: ' . BASE_URL . '/admin/usuarios.php');
    }
} else {
    if ($id) {
        $usuario = $userModel->find($id);

        $_POST['nombre'] = $usuario['nombre'];
        $_POST['correo'] = $usuario['correo'];
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
        <h1 class="mb-4">Crear Usuario</h1>


        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-12">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control <?php echo !empty(getError('nombre')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('nombre'); ?></div>
                </div>
                <div class="col-12">
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" name="correo" id="correo" class="form-control <?php echo !empty(getError('correo')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['correo']) ? $_POST['correo'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('correo'); ?></div>
                </div>
                <div class="col-md-6">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <input type="password" name="contrasena" id="contrasena" class="form-control <?php echo !empty(getError('contrasena')) ? 'is-invalid' : ''; ?>" step="0.01" value="<?php echo isset($_POST['contrasena']) ? $_POST['contrasena'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('contrasena'); ?></div>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>
            </div>
        </form>

    </div>
</div>


<?php include 'view/admin/layout/footer.php' ?>