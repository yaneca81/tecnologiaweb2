<?php
include 'includes/conexion.php'; 
include 'index.php';
$sql = "SELECT cupos.id_cupo, cupos.fecha, cupos.hora, cupos.estado, talleres.nombre FROM cupos JOIN talleres ON cupos.id_taller = talleres.id_taller";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button[onclick*="aceptar"] {
            background-color: #28a745;
        }

        button[onclick*="aceptar"]:hover {
            background-color: #218838;
        }

        button[onclick*="eliminar"] {
            background-color: #dc3545;
        }

        button[onclick*="eliminar"]:hover {
            background-color: #c82333;
        }

        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Lista de Reservas</h1>
    <?php
    include 'includes/conexion.php'; 
    $sql = "SELECT cupos.id_cupo, cupos.fecha, cupos.hora, cupos.estado, talleres.nombre FROM cupos JOIN talleres ON cupos.id_taller = talleres.id_taller";
    $resultado = $conn->query($sql);

    if ($resultado) {
        if ($resultado->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Nombre Taller</th><th>Fecha</th><th>Hora</th><th>Acciones</th></tr>';

            while ($fila = $resultado->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($fila['id_cupo']) . '</td>';
                echo '<td>' . htmlspecialchars($fila['nombre']) . '</td>';
                echo '<td>' . htmlspecialchars($fila['fecha']) . '</td>';
                echo '<td>' . htmlspecialchars($fila['hora']) . '</td>';
                echo '<td>';
                echo '<button onclick="handleAction(' . $fila['id_cupo'] . ', \'aceptar\')">Aceptar</button>';
                echo '<button onclick="handleAction(' . $fila['id_cupo'] . ', \'eliminar\')">Eliminar</button>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No hay reservas disponibles.';
        }

        $resultado->free();
    } else {
        echo 'Error en la consulta: ' . $conn->error;
    }

    $conn->close();
    ?>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message"></p>
            <button class="modal-button">Aceptar</button>
        </div>
    </div>

    <script>
    function handleAction(idCupo, accion) {
        const formData = new FormData();
        formData.append('id_cupo', idCupo);
        formData.append('accion', accion);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'procesar_reserva.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    const modal = document.getElementById('modal');
                    const modalMessage = document.getElementById('modal-message');
                    modalMessage.textContent = response.message;
                    modal.style.display = 'block';
                    if (accion === 'eliminar' && response.message.includes('correctamente')) {
                        // Eliminar la fila de la tabla
                        document.querySelector(`button[onclick="handleAction(${idCupo}, 'eliminar')"]`).parentNode.parentNode.remove();
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    alert('Hubo un error procesando la respuesta del servidor.');
                }
            } else {
                console.error('Error en la solicitud:', xhr.statusText);
                alert('Hubo un error en la solicitud.');
            }
        };
        xhr.send(formData);
    }

    const modal = document.getElementById('modal');
    const span = document.getElementsByClassName('close')[0];
    const modalButton = document.querySelector('.modal-button');

    span.onclick = function() {
        modal.style.display = 'none';
    };

    modalButton.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
    </script>
</body>
</html>
