<?php
session_start(); 

include_once '../incluye/funciones.php';

$rol_usuario = isset($_SESSION['usuario_id']) ? obtenerRolUsuario($_SESSION['usuario_id']) : null;

if ($rol_usuario !== 'empresa') {
    header('Location: ../autentificacion/iniciar_sesion.php');
    exit();
}

$id_empresa = $_SESSION['usuario_id'];
$ofertas = obtenerOfertasPorEmpresa($id_empresa);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['crear'])) {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $requisitos = $_POST['requisitos'];
        $fecha = $_POST['fecha'];
        $salario = $_POST['salario'];
        crearOferta($id_empresa, $titulo, $descripcion, $requisitos, $fecha, $salario);
    } elseif (isset($_POST['editar'])) {
        $id_oferta = $_POST['id_oferta'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $requisitos = $_POST['requisitos'];
        $fecha = $_POST['fecha'];
        $salario = $_POST['salario'];
        editarOferta($id_oferta, $titulo, $descripcion, $requisitos, $fecha, $salario);
    } elseif (isset($_POST['eliminar'])) {
        $id_oferta = $_POST['id_oferta'];
        eliminarOferta($id_oferta);
    }
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Empresa</title>
    <link rel="stylesheet" href="src/css/estilo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        header nav ul li {
            margin: 0 15px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        main {
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }

        .ofertas {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
            overflow-x: auto;
        }

        .oferta {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            width: 300px; /* Ajusta el ancho según sea necesario */
            box-sizing: border-box;
        }

        .oferta h2 {
            margin-top: 0;
        }

        .auth-links {
            text-align: center;
            margin-top: 20px;
        }

        .auth-links a {
            text-decoration: none;
            color: #007bff;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        footer {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .form-container {
            display: none;
            margin-top: 20px;
        }

        .form-container.active {
            display: block;
        }

        .form-container form {
            margin: 0;
        }

        /* Estilos para los botones */
        button, input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover, input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .create-button {
            background-color: #28a745;
        }

        .create-button:hover {
            background-color: #218838;
        }

        .edit-button {
            background-color: #ffc107;
        }

        .edit-button:hover {
            background-color: #e0a800;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../empresas/index.php">Mis Ofertas</a></li>
                <li><a href="../empresas/entrevista.php">Entrevistas</a></li>
                <li><a href="../autentificacion/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Bienvenido, Empresa</h1>

        <button id="show-create-form" class="create-button">Crear Nueva Oferta</button>

        <div id="create-form" class="form-container">
            <h2>Crear Nueva Oferta</h2>
            <form action="" method="post">
                <input type="hidden" name="crear" value="1">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" required>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" required></textarea>

                <label for="requisitos">Requisitos:</label>
                <textarea name="requisitos" id="requisitos"></textarea>

                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" required>

                <label for="salario">Salario:</label>
                <input type="number" name="salario" id="salario" step="0.01">

                <button type="submit" class="create-button">Crear Oferta</button>
            </form>
        </div>

        <h2>Ofertas Existentes</h2>
        <div class="ofertas">
            <?php foreach ($ofertas as $oferta): ?>
                <div class="oferta">
                    <h3><?php echo htmlspecialchars($oferta['titulo']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($oferta['descripcion'])); ?></p>
                    <p><strong>Requisitos:</strong> <?php echo nl2br(htmlspecialchars($oferta['requisitos'])); ?></p>
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($oferta['fecha']); ?></p>
                    <p><strong>Salario:</strong> <?php echo htmlspecialchars($oferta['salario']); ?></p>

                    <button onclick="editOffer(<?php echo htmlspecialchars(json_encode($oferta)); ?>)" class="edit-button">Editar Oferta</button>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="id_oferta" value="<?php echo $oferta['id_oferta']; ?>">
                        <input type="hidden" name="eliminar" value="1">
                        <button type="submit" class="delete-button">Eliminar Oferta</button>
                    </form>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>

        <div id="edit-form" class="form-container">
            <h2>Editar Oferta</h2>
            <form id="edit-form-action" action="" method="post">
                <input type="hidden" name="editar" value="1">
                <input type="hidden" name="id_oferta" id="edit-id-oferta">
                <label for="edit-titulo">Título:</label>
                <input type="text" name="titulo" id="edit-titulo" required>

                <label for="edit-descripcion">Descripción:</label>
                <textarea name="descripcion" id="edit-descripcion" required></textarea>

                <label for="edit-requisitos">Requisitos:</label>
                <textarea name="requisitos" id="edit-requisitos"></textarea>

                <label for="edit-fecha">Fecha:</label>
                <input type="date" name="fecha" id="edit-fecha" required>

                <label for="edit-salario">Salario:</label>
                <input type="number" name="salario" id="edit-salario" step="0.01">

                <button type="submit" class="edit-button">Actualizar Oferta</button>
            </form>
        </div>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Mi Aplicación
    </footer>

    <script>
        document.getElementById('show-create-form').addEventListener('click', function() {
            document.getElementById('create-form').classList.toggle('active');
        });

        function editOffer(oferta) {
            document.getElementById('edit-id-oferta').value = oferta.id_oferta;
            document.getElementById('edit-titulo').value = oferta.titulo;
            document.getElementById('edit-descripcion').value = oferta.descripcion;
            document.getElementById('edit-requisitos').value = oferta.requisitos;
            document.getElementById('edit-fecha').value = oferta.fecha;
            document.getElementById('edit-salario').value = oferta.salario;
            document.getElementById('edit-form').classList.add('active');
        }
    </script>
</body>
</html>

