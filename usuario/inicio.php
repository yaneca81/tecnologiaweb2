<?php
    require('../includes/conexion.php');
    session_start();
    if (isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];
        $conn = Conectar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_profile') 
        {
            $sql = "UPDATE usuario SET IDPerfil = NULL WHERE ID_Usuario = ?";
            $datos = $conn->prepare($sql);
            if ($datos) 
            {
                $datos->bind_param("i", $userID);
                if ($datos->execute()) 
                {
                    echo '<script>
                        Swal.fire({
                            title: "¡Eliminado!",
                            text: "Tu perfil ha sido eliminado.",
                            icon: "success"
                        }).then(() => {
                            window.location.href = "../index.php";
                        });
                    </script>';
                } 
                else
                {
                    echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "Hubo un problema al eliminar tu perfil.",
                            icon: "error"
                        });
                    </script>';
                }
                $datos->close();
            } 
            else 
            {
                echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Error en la consulta.",
                        icon: "error"
                    });
                </script>';
            }
        }
    }
    $sql = "SELECT Usuario, Correo FROM usuario WHERE ID_Usuario = ?";
    $datos = $conn->prepare($sql);
    if ($datos) {
        $datos->bind_param("i", $userID);
        $datos->execute();
        $datos->bind_result($nombre, $correo);
        $datos->fetch();
        $datos->close();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <title>Usuario | Inicio</title>
    <link rel="stylesheet" href="../assets/css/style-barra.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");
        .swal2-title {
            font-family: "Poppins", sans-serif !important;
        }
        .swal2-confirm, .swal2-cancel {
            font-family: "Poppins", sans-serif !important;
            border: none !important; 
            outline: none !important;
            background-color: #8CA49F !important;
            box-shadow: none !important;
            color: white !important;
        }
        .swal2-confirm:hover, .swal2-cancel:hover {
            background-color: black !important;
        }
        .swal2-html-container {
            font-family: "Poppins", sans-serif !important;
        }
    </style>
</head>
<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <img src="../assets/images/portafolio/logo.png" width="60">
                <span>CVNest.</span>
            </div>
            <button class="boton" onclick="window.location.href='perfil.php'">
                <ion-icon name="add-outline"></ion-icon>
                <span>Crear Perfil</span>
            </button>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a id="inbox" href="../usuario/mensajes.php">
                        <ion-icon name="mail-unread-outline"></ion-icon>
                        <span>Mensajes</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="delete-link">
                        <ion-icon name="trash-outline"></ion-icon>
                        <span>Eliminar</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="logout-link">
                        <ion-icon name="exit-outline"></ion-icon>
                        <span>Salir</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div>
            <div class="linea"></div>
            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span>Oscuro</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo"> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="usuario">
                <img src="../assets/images/portafolio/gmail.png" width="50">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre"><?php echo htmlspecialchars($nombre); ?></span>
                        <span class="email"><?php echo htmlspecialchars($correo); ?></span>
                    </div>
                    <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                </div>
            </div>
        </div>
    </div>
    <main>
        <h1>¡Bienvenido a tu cuenta!</h1>
        <p>Empieza a personalizar tu perfil.</p>
        <div class="button-container">
            <button type="button" class="custom-button" onclick="window.location.href='portafolio.php'">
                <ion-icon name="eye-outline"></ion-icon>
                <span>Ver Perfil</span>
            </button>
        </div>
        <img src="../assets/images/portafolio/banner-img.jpg" alt="Descripción de la imagen" class="full-screen-image">
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../assets/scripts/script-barra.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() 
        {
            document.getElementById('logout-link').addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'CvNest.',
                    text: '¿Estás seguro que deseas salir?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, salir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../index.php';
                    }
                });
            });
            document.getElementById('delete-link').addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Eliminar perfil',
                    text: '¿Estás seguro que deseas eliminar tu perfil? Esta acción es irreversible.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>';

                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'action';
                        input.value = 'delete_profile';
                        form.appendChild(input);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
