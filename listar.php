<?php
include 'includes/insertar.php'; 
include 'index.php'; 
$cupos = listar();

if ($cupos === false || !is_array($cupos)) {
    $cupos = [];
    echo "Error: No se pudieron obtener los cupos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cupos</title>
    <link rel="stylesheet" href="estilos\listar.css">
</head>
<body>
    <div class="title-container">
        <h1 class="title">Lista de Cupos</h1>
    </div>
    <div class="cupos-container">
        <?php if (empty($cupos)): ?>
            <p>No hay cupos disponibles.</p>
        <?php else: ?>
            <?php foreach ($cupos as $cupo): ?>
                <div class="cupo" id="cupo-<?php echo $cupo['id_cupo']; ?>">
                    <div class="cupo-info">
                        <p><?php echo isset($cupo['nombre']) ? $cupo['nombre'] : 'Nombre no disponible'; ?>: Información detallada del cupo.</p>
                    </div>
                    <div class="buttons">
                        <button onclick="showEditForm(<?php echo $cupo['id_cupo']; ?>, '<?php echo $cupo['fecha']; ?>', '<?php echo $cupo['hora']; ?>', <?php echo $cupo['id_taller']; ?>, <?php echo $cupo['estado']; ?>)">Editar</button>
                        <button onclick="eliminarCupo(<?php echo $cupo['id_cupo']; ?>)">Eliminar</button>
                        <button onclick="cancelarCupo(<?php echo $cupo['id_cupo']; ?>)">Cancelar</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <a href="registrar_cupo.php"><button class="add-button">Añadir Cupo</button></a>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Editar Cupo</h2>
            <form id="editForm" onsubmit="return editarCupo()">
                <input type="hidden" id="edit-id">
                <input type="date" id="edit-fecha" required>
                <input type="time" id="edit-hora" required>
                <input type="number" id="edit-id_taller" required>
                <input type="number" id="edit-estado" required>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script>
        function showEditForm(id, fecha, hora, id_taller, estado) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-fecha').value = fecha;
            document.getElementById('edit-hora').value = hora;
            document.getElementById('edit-id_taller').value = id_taller;
            document.getElementById('edit-estado').value = estado;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function editarCupo() {
            var id = document.getElementById('edit-id').value;
            var fecha = document.getElementById('edit-fecha').value;
            var hora = document.getElementById('edit-hora').value;
            var id_taller = document.getElementById('edit-id_taller').value;
            var estado = document.getElementById('edit-estado').value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "editar_cupo.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText.trim() === "success") {
                        closeModal();
                        location.reload();
                    } else {
                        alert("Error al editar el cupo: " + xhr.responseText);
                    }
                }
            };
            xhr.send("id_cupo=" + id + "&fecha=" + fecha + "&hora=" + hora + "&id_taller=" + id_taller + "&estado=" + estado);
            return false;
        }

        function eliminarCupo(id_cupo) {
            if (confirm("¿Estás seguro de que quieres eliminar este cupo?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar_cupo.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText.trim() === "success") {
                    document.getElementById('cupo-' + id_cupo).remove();
                } else {
                    alert("Error al eliminar el cupo: " + xhr.responseText);
                }
            }
        };
        xhr.send("id_cupo=" + id_cupo);
    }
}

function cancelarCupo(id_cupo) {
    if (confirm("¿Estás seguro de que quieres cancelar este cupo?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "cancelar_cupo.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText.trim() === "success") {
                    document.getElementById('cupo-' + id_cupo).querySelector('.cupo-info').innerHTML += "<p>Cupo cancelado.</p>";
                } else {
                    alert("Error al cancelar el cupo: " + xhr.responseText);
                }
            }
        };
        xhr.send("id_cupo=" + id_cupo);
            }
        }
    </script>
</body>
</html>
