<?php
require_once 'core/Model.php';
require_once 'model/PropertyModel.php';
require_once 'model/ImageModel.php';

$query = $_GET['query'] ?? null;

$consultaModel = new PropertyModel();
$imageModel = new ImagenModel();

if ($query) {
	$properties = $consultaModel
		->select('id', 'direccion', 'precio', 'num_habitaciones', 'num_baños')
		->where("direccion LIKE '%$query%'",)
		->get();
} else {
	$properties = $consultaModel
		->select('id', 'direccion', 'precio', 'num_habitaciones', 'num_baños')
		->get();
}



foreach ($properties as $key => $property) {
	$images = $imageModel->where('id_propiedad', $property['id'])->select('imagen')->get();
	$properties[$key]['imagenes'] = $images;
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

</head>

<body>

	<?php include('layout/header.php'); ?>

	<div class="hero page-inner overlay" style="background-image: url('<?php echo BASE_URL ?>/assets/images/hero_bg_1.jpg');">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-9 text-center mt-5">
					<h1 class="heading" data-aos="fade-up">Propiedades</h1>
					<nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
						<ol class="breadcrumb text-center justify-content-center">
							<li class="breadcrumb-item "><a href="index.php">Inicio</a></li>
							<li class="breadcrumb-item active text-white-50" aria-current="page">Propiedades</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<div class="section section-properties">
		<div class="row mb-5 align-items-center">
			<div class="col-lg-6 text-center mx-auto">
				<h2 class="font-weight-bold text-primary heading">Escoge que Propiedad deseas</h2>
			</div>
		</div>
		<div class="container">
			<?php if (!empty($properties)) : ?>
				<div class="row">
					<?php foreach ($properties as $property) : ?>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
							<div class="property-item mb-30">
								<?php
								$hasImage = !empty($property['imagenes']);
								$image = $hasImage ? $property['imagenes'][0]['imagen'] : 'casad.jpg';

								?>

								<a href="property.php?id=<?php echo $property['id']; ?>" class="img">

									<?php if ($hasImage) : ?>
										<img src="data:image/jpeg;base64,<?php echo base64_encode($image) ?>" width="600" height="800" alt="Image" class="img-responsive">
									<?php else : ?>
										<img src="<?php echo BASE_URL ?>/assets/images/<?php echo $image; ?>" width="600" height="800" alt="Image" class="img-responsive">
									<?php endif; ?>

								</a>

								<div class="property-content">
									<div class="price mb-2"><span>$<?php echo number_format($property['precio']); ?></span></div>

									<div>
										<span class="d-block mb-2 text-black-50"><?php echo htmlspecialchars($property['direccion']); ?></span>
										<div class="specs d-flex mb-4">
											<span class="d-block d-flex align-items-center me-3">
												<span class="icon-bed me-2"></span>
												<span class="caption"><?php echo htmlspecialchars($property['num_habitaciones']); ?> camas</span>
											</span>
											<span class="d-block d-flex align-items-center">
												<span class="icon-bath me-2"></span>
												<span class="caption"><?php echo $property['num_baños']; ?> baños</span>
											</span>
										</div>
										<a href="property.php?id=<?php echo $property['id']; ?>" class="btn btn-primary py-2 px-3">Ver detalles</a>
									</div>
								</div><!-- .property-item -->
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<h1>NO HAY RESULTADOS</h1>
			<?php endif; ?>
		</div>
	</div>
	<?php include('layout/footer.php'); ?>
</body>

</html>