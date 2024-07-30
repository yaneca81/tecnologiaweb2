<?php
require_once 'model/TipoModel.php';
require_once 'model/LocationModel.php';
require_once 'model/CharacteristicModel.php';
require_once 'model/CharacteristicPropertyModel.php';
require_once 'model/PropertyModel.php';
require_once 'model/ImageModel.php';

$id = $_GET['id'] ?? null;

$typeModel = new TipoModel();
$locationModel = new UbicacionModel();
$characteristicModel = new CaracteristicaModel();
$characteristicPropertyModel = new PropiedadCaracteristicaModel();
$consultaModel = new PropertyModel();
$imageModel = new ImagenModel();

$types = $typeModel->get();
$locations = $locationModel->get();
$characteristics = $characteristicModel->get();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTipo = $_POST['id_tipo'] ?? '';
    $idUbicacion = $_POST['id_ubicacion'] ?? '';
    $direccion = trim($_POST['direccion'] ?? '');
    $precio = is_numeric($_POST['precio']) ? (float)$_POST['precio'] : '';
    $superficieTotal = is_numeric($_POST['superficie_total']) ? (float)$_POST['superficie_total'] : '';
    $superficieConstruida = is_numeric($_POST['superficie_construida']) ? (float)$_POST['superficie_construida'] : '';
    $numHabitaciones = is_numeric($_POST['num_habitaciones']) ? (int)$_POST['num_habitaciones'] : '';
    $numBaños = is_numeric($_POST['num_baños']) ? (int)$_POST['num_baños'] : '';
    $añoConstruccion = $_POST['año_construccion'] ?? '';
    $estado = trim($_POST['estado'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    $selectedCaracteristicas = $_POST['caracteristicas'] ?? [];

    $requiredFields = ['id_tipo', 'id_ubicacion', 'direccion', 'precio', 'superficie_total', 'superficie_construida', 'num_habitaciones', 'num_baños', 'año_construccion', 'estado', 'descripcion'];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Este campo es obligatorio';
        }
    }

    if (!empty($direccion)) {
        if (strlen($direccion) < 5) {
            $errors['direccion'] = 'La dirección debe tener al menos 5 caracteres';
        } elseif (strlen($direccion) > 300) {
            $errors['direccion'] = 'La dirección no puede tener más de 300 caracteres';
        }
    }

    if (!empty($precio)) {
        if (!is_numeric($precio)) {
            $errors['precio'] = 'El precio debe ser un número';
        } elseif ($precio < 0) {
            $errors['precio'] = 'El precio no puede ser negativo';
        }
    }


    if (!empty($superficieTotal)) {
        if (!is_numeric($superficieTotal)) {
            $errors['superficie_total'] = 'La superficie total debe ser un número';
        } elseif ($superficieTotal < 0) {
            $errors['superficie_total'] = 'La superficie total no puede ser negativa';
        }
    }


    if (!empty($superficieConstruida)) {
        if (!is_numeric($superficieConstruida)) {
            $errors['superficie_construida'] = 'La superficie construida debe ser un número';
        } elseif ($superficieConstruida < 0) {
            $errors['superficie_construida'] = 'La superficie construida no puede ser negativa';
        }
    }


    if (!empty($numHabitaciones)) {
        if (!is_numeric($numHabitaciones)) {
            $errors['num_habitaciones'] = 'El número de habitaciones debe ser un número';
        } elseif ($numHabitaciones < 0) {
            $errors['num_habitaciones'] = 'El número de habitaciones no puede ser negativo';
        } elseif (!is_int($numHabitaciones)) {
            $errors['num_habitaciones'] = 'El número de habitaciones debe ser un número entero';
        }
    }


    if (!empty($numBaños)) {
        if (!is_numeric($numBaños)) {
            $errors['num_baños'] = 'El número de baños debe ser un número';
        } elseif ($numBaños < 0) {
            $errors['num_baños'] = 'El número de baños no puede ser negativo';
        } elseif (!is_int($numBaños)) {
            $errors['num_baños'] = 'El número de baños debe ser un número entero';
        }
    }


    if (!empty($añoConstruccion)) {
        $fecha = strtotime($añoConstruccion);
        $fechaActualStrTime = strtotime(date('Y-m-d'));
        $year = date('Y', $fecha);

        if ($year < 1800) {
            $errors['año_construccion'] = 'La fecha de construcción no puede ser anterior a 1800';
        } elseif ($fecha > $fechaActualStrTime) {
            $errors['año_construccion'] = 'La fecha de construcción no puede ser posterior al año actual';
        }
    }


    if (!empty($estado)) {
        if (strlen($estado) < 3) {
            $errors['estado'] = 'El estado debe tener al menos 3 caracteres';
        } elseif (strlen($estado) > 50) {
            $errors['estado'] = 'El estado no puede tener más de 50 caracteres';
        }
    }


    if (!empty($descripcion)) {
        if (strlen($descripcion) < 10) {
            $errors['descripcion'] = 'La descripción debe tener al menos 10 caracteres';
        } elseif (strlen($descripcion) > 300) {
            $errors['descripcion'] = 'La descripción no puede tener más de 300 caracteres';
        }
    }

    $imagenes = $_FILES['imagenes'];

    $imagesToUpload = [];



    if (!empty($imagenes['name'][0])) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 5 * 1024 * 1024;

        foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
            $file_name = $imagenes['name'][$key];
            $file_size = $imagenes['size'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (!in_array($file_ext, $allowedExtensions)) {
                $errors['imagenes'] = 'Solo se permiten archivos JPG, JPEG, PNG y GIF';
                break;
            }

            if ($file_size > $maxFileSize) {
                $errors['imagenes'] = 'El tamaño máximo de archivo permitido es 5 MB';
                break;
            }

            $dimensions = getimagesize($tmp_name);
            $width = $dimensions[0];
            $height = $dimensions[1];
            $type = $dimensions['mime'];
            $image = file_get_contents($tmp_name);
            $name = $file_name;

            $fileContent = file_get_contents($tmp_name);
            $fileContent = addslashes($fileContent);

            $imagesToUpload[] = [
                'nombre' => $name,
                'tipo' => $type,
                'ancho' => $width,
                'altura' => $height,
                'imagen' => $image
            ];
        }
    }

    if (empty($errors)) {
        if (!$id) {
            $idPropiedad =  $consultaModel->create([
                'id_tipo' => $idTipo,
                'id_ubicacion' => $idUbicacion,
                'direccion' => $direccion,
                'precio' => $precio,
                'superficie_total' => $superficieTotal,
                'superficie_construida' => $superficieConstruida,
                'num_habitaciones' => $numHabitaciones,
                'num_baños' => $numBaños,
                'año_construccion' => $añoConstruccion,
                'estado' => $estado,
                'descripcion' => $descripcion,
                'id_usuario' => 1, //TODO: Cambiar por el ID del usuario logueado  $_SESSION['user']['id']
            ]);

            foreach ($selectedCaracteristicas as $caracteristica) {
                $characteristicPropertyModel->create([
                    'id_caracteristica' => $caracteristica,
                    'id_propiedad' => $idPropiedad,
                    'valor' => 'si'
                ]);
            }

            foreach ($imagesToUpload as $image) {
                $image['id_propiedad'] = $idPropiedad;
                $imageModel->create($image);
            }
        } else {
            $consultaModel->update($id, [
                'id_tipo' => $idTipo,
                'id_ubicacion' => $idUbicacion,
                'direccion' => $direccion,
                'precio' => $precio,
                'superficie_total' => $superficieTotal,
                'superficie_construida' => $superficieConstruida,
                'num_habitaciones' => $numHabitaciones,
                'num_baños' => $numBaños,
                'año_construccion' => $añoConstruccion,
                'estado' => $estado,
                'descripcion' => $descripcion,
                'id_usuario' => 1, //TODO: Cambiar por el ID del usuario logueado  $_SESSION['user']['id']
            ]);

            $propertyCharacteristics  = $characteristicPropertyModel
                ->select('caracteristica.nombre', 'caracteristica.descripcion', 'caracteristica.id')
                ->join('caracteristica', 'caracteristica.id = propiedad_caracteristica.id_caracteristica')
                ->where('id_propiedad', $id)
                ->get();

            $saveCharacteristics = [];

            foreach ($propertyCharacteristics as $characteristic) {
                $characteristicPropertyModel->executeQuery("DELETE FROM propiedad_caracteristica WHERE id_propiedad = $id AND id_caracteristica = {$characteristic['caracteristica']['id']}");
            }

            foreach ($selectedCaracteristicas as $caracteristica) {
                $characteristicPropertyModel->create([
                    'id_caracteristica' => $caracteristica,
                    'id_propiedad' => $id,
                    'valor' => 'si'
                ]);
            }

            /* foreach ($imagesToUpload as $image) {
                $image['id_propiedad'] = $idPropiedad;
                $imageModel->create($image);
            } */
        }

        header('Location: ' . BASE_URL . '/admin/propiedades.php');
    }
} else {
    if ($id) {
        $property = $consultaModel->find($id);

        $_POST['id_tipo'] = $property['id_tipo'];
        $_POST['id_ubicacion'] = $property['id_ubicacion'];
        $_POST['direccion'] = $property['direccion'];
        $_POST['precio'] = $property['precio'];
        $_POST['superficie_total'] = $property['superficie_total'];
        $_POST['superficie_construida'] = $property['superficie_construida'];
        $_POST['num_habitaciones'] = $property['num_habitaciones'];
        $_POST['num_baños'] = $property['num_baños'];
        $_POST['año_construccion'] = $property['año_construccion'];
        $_POST['estado'] = $property['estado'];
        $_POST['descripcion'] = $property['descripcion'];

        // HASTA AQUI YA ESTARIA
        // NO HACE FALTA ESTO YA QUE MI TABLA ES DE MUCHOS A MUCHOS Y LAS DE USTEDES SON DE 1
        $propertyCharacteristics  = $characteristicPropertyModel
            ->select('caracteristica.nombre', 'caracteristica.descripcion', 'caracteristica.id')
            ->join('caracteristica', 'caracteristica.id = propiedad_caracteristica.id_caracteristica')
            ->where('id_propiedad', $id)
            ->get();

        $saveCharacteristics = [];

        foreach ($propertyCharacteristics as $characteristic) {
            $_POST['caracteristicas'][] = $characteristic['caracteristica']['id'];
        }
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
        <h1 class="mb-4">Crear Propiedad</h1>


        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="id_tipo" class="form-label">Tipo:</label>
                    <select name="id_tipo" id="id_tipo" class="form-select <?php echo !empty(getError('id_tipo')) ? 'is-invalid' : ''; ?>">
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php foreach ($types as $tipo) : ?>
                            <option value="<?php echo $tipo['id']; ?>" <?php echo (isset($_POST['id_tipo']) && $_POST['id_tipo'] == $tipo['id']) ? 'selected' : ''; ?>><?php echo $tipo['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?php echo getError('id_tipo'); ?></div>
                </div>

                <div class="col-md-6">
                    <label for="id_ubicacion" class="form-label">Ubicación:</label>
                    <select name="id_ubicacion" id="id_ubicacion" class="form-select <?php echo !empty(getError('id_ubicacion')) ? 'is-invalid' : ''; ?>">
                        <option value="" selected disabled>Seleccione una ubicación</option>
                        <?php foreach ($locations as $ubicacion) : ?>
                            <option value="<?php echo $ubicacion['id']; ?>" <?php echo (isset($_POST['id_ubicacion']) && $_POST['id_ubicacion'] == $ubicacion['id']) ? 'selected' : ''; ?>><?php echo $ubicacion['ciudad'] . ', ' . $ubicacion['departamento'] . ', ' . $ubicacion['pais']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?php echo getError('id_ubicacion'); ?></div>
                </div>

                <div class="col-12">
                    <label for="direccion" class="form-label">Dirección:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control <?php echo !empty(getError('direccion')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['direccion']) ? $_POST['direccion'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('direccion'); ?></div>
                </div>

                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio:</label>
                    <input type="number" name="precio" id="precio" class="form-control <?php echo !empty(getError('precio')) ? 'is-invalid' : ''; ?>" step="0.01" value="<?php echo isset($_POST['precio']) ? $_POST['precio'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('precio'); ?></div>
                </div>

                <div class="col-md-6">
                    <label for="superficie_total" class="form-label">Superficie Total (m²):</label>
                    <input type="number" name="superficie_total" id="superficie_total" step="0.01" class="form-control <?php echo !empty(getError('superficie_total')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['superficie_total']) ? $_POST['superficie_total'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('superficie_total'); ?></div>
                </div>

                <div class="col-md-6">
                    <label for="superficie_construida" class="form-label">Superficie Construida (m²):</label>
                    <input type="number" name="superficie_construida" id="superficie_construida" step="0.01" class="form-control <?php echo !empty(getError('superficie_construida')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['superficie_construida']) ? $_POST['superficie_construida'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('superficie_construida'); ?></div>
                </div>

                <div class="col-md-3">
                    <label for="num_habitaciones" class="form-label">Número de Habitaciones:</label>
                    <input type="number" name="num_habitaciones" id="num_habitaciones" class="form-control <?php echo !empty(getError('num_habitaciones')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['num_habitaciones']) ? (int) $_POST['num_habitaciones'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('num_habitaciones'); ?></div>
                </div>

                <div class="col-md-3">
                    <label for="num_baños" class="form-label">Número de Baños:</label>
                    <input type="number" name="num_baños" id="num_baños" class="form-control <?php echo !empty(getError('num_baños')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['num_baños']) ? $_POST['num_baños'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('num_baños'); ?></div>
                </div>

                <div class="col-md-6">
                    <label for="año_construccion" class="form-label">Año de Construcción:</label>
                    <input type="date" name="año_construccion" id="año_construccion" class="form-control <?php echo !empty(getError('año_construccion')) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['año_construccion']) ? $_POST['año_construccion'] : ''; ?>">
                    <div class="invalid-feedback"><?php echo getError('año_construccion'); ?></div>
                </div>

                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado:</label>
                    <select name="estado" id="estado" class="form-select <?php echo !empty(getError('estado')) ? 'is-invalid' : ''; ?>">
                        <option value="" selected disabled>Seleccione un estado</option>
                        <option value="Activo" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                        <option value="Inactivo" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                    <div class="invalid-feedback"><?php echo getError('estado'); ?></div>
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" class="form-control <?php echo !empty(getError('descripcion')) ? 'is-invalid' : ''; ?>" "  rows=" 3"><?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?></textarea>
                    <div class="invalid-feedback"><?php echo getError('descripcion'); ?></div>
                </div>

                <div class="col-12">
                    <label class="form-label">Características:</label>

                    <?php if (!empty($characteristics)) : ?>
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            <?php foreach ($characteristics as $caracteristica) : ?>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="caracteristicas[]" id="caracteristica_<?php echo $caracteristica['id']; ?>" value="<?php echo $caracteristica['id']; ?>" <?php echo (isset($_POST['caracteristicas']) && in_array($caracteristica['id'], $_POST['caracteristicas'])) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="caracteristica_<?php echo $caracteristica['id']; ?>"><?php echo $caracteristica['nombre']; ?></label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="text-black mt-2">No hay características disponibles</p>
                    <?php endif; ?>

                </div>

                <div class="col-12">
                    <label for="imagenes" class="form-label">Imágenes:</label>
                    <input type="file" name="imagenes[]" id="imagenes" class="form-control <?php echo !empty(getError('imagenes')) ? 'is-invalid' : ''; ?>" multiple accept="image/*">

                    <div class="invalid-feedback"><?php echo getError('imagenes'); ?></div>

                    <div id="imagenes_preview" class="mt-2 d-flex flex-wrap"></div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary">Crear Propiedad</button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
    document.getElementById('imagenes').addEventListener('change', function(e) {
        var preview = document.getElementById('imagenes_preview');
        preview.innerHTML = '';
        for (var i = 0; i < e.target.files.length; i++) {
            var file = e.target.files[i];
            var img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'img-thumbnail m-1';
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.objectFit = 'cover';
            preview.appendChild(img);
        }
    });
</script>


<?php include 'view/admin/layout/footer.php' ?>