<?php include 'index.php';?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Taller</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/taller.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .form-container {
            background-color: #fff;
            color: #333;
            padding: 20px;
            margin: 30px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
        }
        .form-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-container label {
            display: block;
            font-size: 16px;
            margin: 10px 0 5px;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }
        .form-container input[type="number"] {
            -moz-appearance: textfield;
        }
        .form-container input[type="number"]::-webkit-inner-spin-button,
        .form-container input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .form-container button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="message" id="mensajeConfirmacion"></div>
    <div class="form-container">
        <h1>Registrar Nuevo Taller</h1>
        <form id="registroTallerForm">
            <label for="nombre">Nombre del Taller:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>
            
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono">
            
            <label for="cupos_diarios">Cupos Diarios:</label>
            <input type="number" id="cupos_diarios" name="cupos_diarios" required min="1">
            
            <button type="submit">Registrar</button>
        </form>
    </div>

    <script>
        document.getElementById('registroTallerForm').onsubmit = function(event) {
            event.preventDefault(); 

            if (!validarFormulario()) {
                return;
            }

            const formData = new FormData(this);

            fetch('procesar_taller.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensajeDiv = document.getElementById('mensajeConfirmacion');
                if (data.success) {
                    mensajeDiv.textContent = 'El taller se ha registrado exitosamente.';
                    mensajeDiv.style.color = 'green';
                    this.reset(); 
                } else {
                    mensajeDiv.textContent = 'Hubo un error al registrar el taller.';
                    mensajeDiv.style.color = 'red';
                }
                mensajeDiv.style.display = 'block'; 
            })
            .catch(error => console.error('Error:', error));
        };

        function validarFormulario() {
            var telefono = document.getElementById('telefono').value;
            if (telefono !== '' && !/^\d{7,15}$/.test(telefono)) {
                alert("El teléfono debe tener entre 7 y 15 dígitos.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>


