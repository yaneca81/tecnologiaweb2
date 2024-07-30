<?php

require_once 'model/PropertyModel.php';
require_once 'model/LocationModel.php';
require_once 'model/ImageModel.php';
require_once 'model/CharacteristicPropertyModel.php';
require_once 'model/ConsultaModel.php';

$id = $_GET['id'] ?? null;

if (!$id) {
	header('Location: ' . BASE_URL);
}

$consultaModel = new PropertyModel();
$locationModel = new UbicacionModel();
$imageModel = new ImagenModel();
$propiedadCaracteristicaModel = new PropiedadCaracteristicaModel();
$citaModel = new ConsultaModel();


$property = $consultaModel->find($id);

if (!$property) {
	header('Location: ' . BASE_URL);
}

$location = $locationModel->find($property['id_ubicacion']);

$images = $imageModel->where('id_propiedad', $property['id'])->get();

$propiedadCaracteristicas = $propiedadCaracteristicaModel
	->select('caracteristica.nombre', 'caracteristica.descripcion', 'caracteristica.id')
	->join('caracteristica', 'caracteristica.id = propiedad_caracteristica.id_caracteristica')
	->where('id_propiedad', $property['id'])
	->get();

$caracteristicas = [];
foreach ($propiedadCaracteristicas as $caracteristica) {
	$caracteristicas[] = $caracteristica['caracteristica'];
}

$hasImage = !empty($images);

// Obtener la ubicación de la propiedad, incluyendo latitud y longitud
$location = $locationModel->find($property['id_ubicacion']);
if (!$location) {
	die('Ubicación no encontrada.');
}

$latitud = $location['latitud'];
$longitud = $location['longitud'];



if (isset($_POST['submit'])) {
    $error = [];
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
	$gmail = isset($_POST['gmail']) ? $_POST['gmail'] : "";
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
	$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : "";

    if (strlen($nombre) <= 0) {
        $error[0]="<font color='#FF0000'> Nombre es requerido";
    }
    elseif (strlen($nombre) <= 3 || strlen($nombre) >= 20) {
        $error[0]="<font color='#FF0000'>El nombre tiene que tener mínimo 3 letras y máximo 20 letras. </font>"."<br>";  
    }
    if (strlen($gmail) <= 0) {
        $error[1]="<font color='#FF0000'> Gmail es requerido";
    }
    elseif (!preg_match('/@gmail\.com$/', $gmail)) {
        $error[1]="<font color='#FF0000'>El gmail ingresado es incorrecto</font>"."<br>";
    }
    if (strlen($telefono) <= 0) {
        $error[2]="<font color='#FF0000'> Telefono es requerido";
    }
    elseif (strlen($telefono) < 8 || strlen($telefono) > 8) {
        $error[2]="<font color='#FF0000'>El telefono tiene que tener 8 digitos. </font>"."<br>";  
    }
	if (strlen($mensaje) <= 0) {
        $error[3]="<font color='#FF0000'> Mensaje es requerido";
    }
    elseif (strlen($mensaje) <= 3 || strlen($mensaje) >= 50) {
        $error[3]="<font color='#FF0000'>El mensaje tiene que tener mínimo 3 letras y máximo 50 letras. </font>"."<br>";  
    }

    if (empty($error)) {
		$citaModel->create([
			'id_propiedad'=>$id,
			'nombre'=>$nombre,
			'correo'=>$gmail,
			'telefono'=>$telefono,
			'mensaje'=>$mensaje
		]);
		$men[0]="<font color='#0EAF15'> Cita Registrada Correctamente";
    }
}



?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap5" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">


	<link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/fonts/icomoon/style.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/fonts/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/tiny-slider.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/aos.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>/assets/css/style.css">

	<title>Property &mdash; Free Bootstrap 5 Website Template by Untree.co</title>
</head>

<body>

	<?php include('layout/header.php'); ?>


	<div class="hero page-inner overlay" style="background-image: url('<?= BASE_URL ?>/assets/images/hero_bg_3.jpg');">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-9 text-center mt-5">
					<h1 class="heading" data-aos="fade-up"><?php echo htmlspecialchars($property['direccion']); ?></h1>

					<nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
						<ol class="breadcrumb text-center justify-content-center">
							<li class="breadcrumb-item "><a href="<?php echo BASE_URL ?>/index.php">Inicio</a></li>
							<li class="breadcrumb-item "><a href="<?php echo BASE_URL ?>/properties.php">Propiedades</a></li>
							<li class="breadcrumb-item active text-white-50" aria-current="page"><?php echo htmlspecialchars($property['direccion']); ?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>


	<div class="section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-7">
					<div class="img-property-slide-wrap">
						<div class="img-property-slide">
							<?php if ($hasImage) : ?>
								<?php foreach ($images as $image) : ?>
									<img src="data:image/jpeg;base64,<?= base64_encode($image['imagen']) ?>" alt="Image" class="img-fluid">
								<?php endforeach; ?>
							<?php else : ?>
								<img src="<?= BASE_URL ?>/assets/images/casad.jpg" alt="Image" class="img-fluid">
							<?php endif; ?>

						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<h2 class="heading text-primary"><?php echo htmlspecialchars($property['direccion']); ?></h2>
					<div class="price mb-4"><span>$<?php echo number_format($property['precio']); ?></span></div>
					<div class="specs d-flex mb-4">
						<span class="d-block d-flex align-items-center me-3">
							<span class="icon-bed me-2"></span>
							<span class="caption"><?php echo htmlspecialchars($property['num_habitaciones']); ?> camas</span>
						</span>
						<span class="d-block d-flex align-items-center">
							<span class="icon-bath me-2"></span>
							<span class="caption"><?php echo htmlspecialchars($property['num_baños']); ?> baños</span>
						</span>
					</div>
					<div class="location mb-4">
						<span class="d-block mb-2">Ubicación:</span>
						<span><?php echo htmlspecialchars($location['ciudad'] . ', ' . $location['departamento'] . ', ' . $location['pais']); ?></span>
					</div>
					<div class="description mb-4">
						<p><?php echo htmlspecialchars($property['descripcion']); ?></p>
					</div>
					<div class="features mb-4">
						<h3 class="heading text-primary">Características</h3>
						<ul class="list-unstyled">
							<?php foreach ($caracteristicas as $caracteristica) : ?>
								<li><?php echo htmlspecialchars($caracteristica['nombre'] . ': ' . $caracteristica['descripcion']); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section" align="center">
		<div class="container">
			<div class="row">
				<div class="row mb-5 align-items-center">
					<div class="col-lg-6 text-center mx-auto">
						<h2 class="font-weight-bold text-primary heading">Ubicacion de la Propiedad</h2>
					</div>
				</div>
				<div class="col-lg-8">
					<?php if ($latitud && $longitud): ?>
					<iframe 
						src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d59378.116142524115!2d<?php echo $longitud; ?>!3d<?php echo $latitud; ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sbo!4v1722309007128!5m2!1ses!2sbo"
						width="1300" 
						height="600" 
						style="border:0;" 
						allowfullscreen="" 
						loading="lazy" 
						referrerpolicy="no-referrer-when-downgrade">
					</iframe>
					<?php else: ?>
						<p>La ubicación de la propiedad no está disponible.</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>


	<div class="section">
		<div class="container">
			<div class="row"></div>
				<div class="row mb-5 align-items-center">
					<div class="col-lg-6 text-center mx-auto">
						<h2 class="font-weight-bold text-primary heading">Agenda tu Cita</h2>
					</div>
				</div>
				<form action="" method="post">
					<div class="row">
						<div class="col-6 mb-3">
							<input type="text" name="nombre" class="form-control" placeholder="Escribe tu nombre" class="<?php echo isset($error[0]) ? 'input-error' : ''; ?>">
							<?php 
        					if (isset($error[0])) {
            					echo '<p class="error">'.$error[0].'</p>';
        					}
        					?>
						</div>
						<div class="col-6 mb-3">
							<input type="text" name="gmail" class="form-control" placeholder="Escribe tu gmail" class="<?php echo isset($error[1]) ? 'input-error' : ''; ?>">
							<?php 
        					if (isset($error[1])) {
            					echo '<p class="error">'.$error[1].'</p>';
        					}
        					?>						
						</div>
						<div class="col-12 mb-3">
							<input type="text" name="telefono" class="form-control" placeholder="Escribe tu numero telefonico" class="<?php echo isset($error[2]) ? 'input-error' : ''; ?>">
							<?php 
        					if (isset($error[2])) {
            					echo '<p class="error">'.$error[2].'</p>';
        					}
        					?>
						</div>
						<div class="col-12 mb-3">
							<textarea name="mensaje" id="" cols="30" rows="7" class="form-control" placeholder="Escribe tu mensaje" class="<?php echo isset($error[3]) ? 'input-error' : ''; ?>"></textarea>
							<?php 
        					if (isset($error[3])) {
            					echo '<p class="error">'.$error[3].'</p>';
        					}
        					?>
						</div>

						<div class="col-12">
							<input type="submit" name="submit" value="Enviar mensaje" class="btn btn-primary" class="<?php echo isset($men[0]) ? 'input-error' : ''; ?>">
							<?php
							if (isset($men[0])) {
            					echo '<p class="error">'.$men[0].'</p>';
        					}
        					?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php include('layout/footer.php'); ?>
</body>

</html>