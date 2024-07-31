<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
<title>CVNest.</title>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");
    .swal2-title {
        font-family: "Poppins", sans-serif !important;;
    }
    .swal2-confirm {
        font-family: "Poppins", sans-serif !important;
        border: none !important; 
        outline: none !important;
        background-color: #8CA49F !important;
        box-shadow: none !important;
        color: white !important;
        }

    .swal2-confirm:hover {
        background-color: black !important;;
    }
    .swal2-html-container {
        font-family: "Poppins", sans-serif !important;
    }
    .swal2-cancel {
        font-family: "Poppins", sans-serif !important;
        border: none !important; 
        outline: none !important;
        background-color: #8CA49F !important;
        box-shadow: none !important;
        color: white !important;
        }

    .swal2-cancel:hover {
        background-color: black !important;;
    }
</style>
<?php
    session_start();
    require_once('conexion.php');
    $conexion = Conectar();
    // Función de Registro:
    function Registrarse($usuario, $correo, $contraseña)
    {
        global $conexion;
        
        $errores = [];
        
        // Validación:
        if (empty($usuario)) {
            $errores[0] = "El campo <strong>usuario</strong> no puede estar vacío";
        } elseif (strlen($usuario) >= 20) {
            $errores[0] = "El campo <strong>usuario</strong> no puede tener más de 20 caracteres";
        }
        if (empty($correo)) {
            $errores[1] = "El campo <strong>correo</strong> no puede estar vacío";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[1] = "El formato del <strong>correo</strong> no es válido";
        } elseif (strlen($correo) > 50) {
            $errores[1] = "El campo <strong>correo</strong> no puede tener más de 50 caracteres";
        }
        if (empty($contraseña)) {
            $errores[2] = "El campo <strong>contraseña</strong> no puede estar vacío";
        } elseif (strlen($contraseña) > 15) {
            $errores[2] = "El campo <strong>contraseña</strong> puede tener un máximo de 15 caracteres";
        }

        if (!empty($errores)) {
            $_SESSION['errores'] = $errores;
            $_SESSION['valores'] = ['usuario' => $usuario, 'correo' => $correo];
            header(": ../inicio.php");
            exit();
        }
        // Consulta:
        $usuario = mysqli_real_escape_string($conexion, $usuario);
        $correo = mysqli_real_escape_string($conexion, $correo);
        $contraseña = mysqli_real_escape_string($conexion, $contraseña);
        $consulta = "INSERT INTO USUARIO (usuario, correo, contraseña) VALUES ('$usuario', '$correo', '$contraseña')";
        if (mysqli_query($conexion, $consulta)) 
        {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'CvNest.',
                            text: 'Usuario registrado exitosamente.',
                            icon: 'success',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../index.php';
                            }
                        });
                    });
                </script>";
        } 
        else 
        {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'CvNest.',
                            text: 'Error al registrar el usuario: " . mysqli_error($conexion) . "',
                            icon: 'error'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../index.php';
                            }
                        });
                    });
                </script>";
        }
        mysqli_close($conexion);
    }
    // Función Inicio Sesión
    function Validar($correo, $contraseña) 
    {
        global $conexion;
        $consulta = "SELECT * FROM USUARIO WHERE correo = ? AND contraseña = ?";
        $stmt = $conexion->prepare($consulta);
        if ($stmt === false) 
        {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        $stmt->bind_param("ss", $correo, $contraseña);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) 
        {
            $usuario = $resultado->fetch_assoc();
            if (isset($usuario['ID_Usuario'])) 
            {
                $userID = $usuario['ID_Usuario']; 
                $_SESSION['userID'] = $userID;
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'CvNest.',
                                text: 'Sesión iniciada exitosamente.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '../usuario/inicio.php';
                                }
                            });
                        });
                    </script>";
                return true;
            } 
            else 
            {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'CvNest.',
                                text: 'Error: El campo ID no está definido en el resultado.',
                                icon: 'error'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '../inicio.php';
                                }
                            });
                        });
                    </script>";
                return false;
            }
        } 
        else 
        {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'CvNest.',
                            text: 'Correo o contraseña incorrectos.',
                            icon: 'error'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../inicio.php';
                            }
                        });
                    });
                </script>";
            return false;
        }
    }
    // Llamado de las funciones:
    if (isset($_POST['accion'])) 
    {
        $acción = $_POST['accion'];
        if ($acción == 'validar') 
        {
            $usercorreo = $_POST['UserCorreo'] ?? '';
            $usercontraseña = $_POST['UserContraseña'] ?? '';
            Validar($usercorreo, $usercontraseña);
        } 
        elseif ($acción == 'registrar') 
        {
            $usuario = $_POST['usuario'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $contraseña = $_POST['contraseña'] ?? '';
            Registrarse($usuario, $correo, $contraseña);
        } 
        else 
        {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'CvNest.',
                            text: 'No se recibió ninguna acción válida.',
                            icon: 'error'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../index.php';
                            }
                        });
                    });
                </script>";
        }
    } 
    else 
    {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'CvNest.',
                        text: 'No se recibió ninguna acción.',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../index.php';
                        }
                    });
                });
            </script>";
    }
?>