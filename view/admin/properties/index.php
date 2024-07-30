<?php
include 'view/admin/layout/header.php';
require_once 'model/PropertyModel.php';

$consultaModel  = new PropertyModel();
$consultas = $consultaModel->get();
?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>LISTA DE PROPIEDADES</h1>
            <a class="btn btn-primary" href="<?php echo BASE_URL ?>/admin/propiedades/form">
                CREAR
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Superficie </th>
                        <th scope="col">Nº Hab.</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $propiedad) : ?>
                        <tr>
                            <th scope="row"><?php echo $propiedad['id'] ?></th>
                            <td><?php echo $propiedad['direccion'] ?></td>
                            <td><?php echo number_format($propiedad['precio']) ?></td>
                            <td><?php echo $propiedad['superficie_total'] ?></td>
                            <td><?php echo $propiedad['num_habitaciones'] ?></td>
                            <td><?php echo $propiedad['estado'] ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm " href="<?php echo BASE_URL ?>/admin/propiedades/form?id=<?php echo $propiedad['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg>
                                </a>

                                <a class="btn btn-danger btn-sm delete-btn" href="<?php echo BASE_URL ?>/admin/delete?id=<?php echo $propiedad['id']; ?>&entity=propiedad">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include 'view/admin/layout/footer.php' ?>