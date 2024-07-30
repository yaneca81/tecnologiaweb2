<?php
include 'view/admin/layout/header.php';
require_once 'model/ConsultaModel.php';

$consultaModel  = new ConsultaModel();
$consultas = $consultaModel
    ->get();
?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>LISTA DE CONSULTAS</h1>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Mensaje</th>
                        <th scope="col">Propiedad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $consulta) : ?>
                        <tr>
                            <th scope="row"><?php echo $consulta['id'] ?></th>
                            <td><?php echo $consulta['nombre'] ?></td>
                            <td><?php echo $consulta['correo'] ?></td>
                            <td><?php echo $consulta['telefono'] ?></td>
                            <td><?php echo $consulta['mensaje'] ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/property.php?id=<?= $consulta['id_propiedad'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
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