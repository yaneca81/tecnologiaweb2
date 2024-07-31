<?php
    session_start();
    require('includes/conexion.php');
    $conexion = Conectar();

    $errores = $_SESSION['errores'] ?? [];
    $valores = $_SESSION['valores'] ?? [];
    unset($_SESSION['errores']);
    unset($_SESSION['valores']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./assets/css/style-inicio.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <title>Bienvenido a CVNest.</title>
</head>
<body>
    <div class="container-form register">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido</h2>
                <p>Para unirte a nuestra comunidad por favor Inicia Sesión con tus datos</p>
                <input type="button" value="Iniciar Sesión" id="sign-in">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear una Cuenta</h2>
                <div class="icons">
                    <i class='bx bxl-google'></i>
                    <i class='bx bxl-github'></i>
                    <i class='bx bxl-linkedin' ></i>
                </div>
                <p>o usa tu email para registrarte</p>
                <!-- Registro -->
                <form action="includes/funciones.php" method="post" class="form form-register" novalidate>
                    <input type="hidden" name="accion" value="registrar">
                    <div>
                        <label>
                            <i class='bx bx-user' ></i>
                            <input type="text" placeholder="Nombre Usuario" name="usuario" value="<?php echo isset($valores['usuario']) ? htmlspecialchars($valores['usuario']) : ''; ?>" >
                        </label>
                    </div>
                    <?php if (isset($errores[0])) { echo "<p style='color: #A93226; font-size: 12px; margin: 5px 0;'>" . $errores[0] . "</p>"; } ?>
                    <div>
                        <label >
                            <i class='bx bx-envelope' ></i>
                            <input type="email" placeholder="Correo Electrónico" name="correo" value="<?php echo isset($valores['correo']) ? htmlspecialchars($valores['correo']) : ''; ?>">
                        </label>
                    </div>
                    <?php if (isset($errores[1])) { echo "<p style='color: #A93226; font-size: 12px; margin: 5px 0;'>" . $errores[1] . "</p>"; } ?>
                   <div>
                        <label>
                            <i class='bx bx-lock-alt' ></i>
                            <input type="password" placeholder="Contraseña" name="contraseña">
                        </label>
                   <?php if (isset($errores[2])) { echo "<p style='color: #A93226; font-size: 12px; margin: 5px 0;'>" . $errores[2] . "</p>"; } ?>
                   </div>

                    <input type="submit" value="Registrarse" name="submit">
                    <div class="alerta-error">Todos los campos son obligatorios</div>
                    <div class="alerta-exito">Te registraste correctamente</div>
                </form>
            </div>
        </div>
    </div>
    <!-- Inicio de Sesión -->
    <div class="container-form login hide">
        <div class="information">
            <div class="info-childs">
                <h2>¡¡Bienvenido nuevamente!!</h2>
                <p>Para unirte a nuestra comunidad por favor Inicia Sesión con tus datos</p>
                <input type="button" value="Registrarse" id="sign-up">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Iniciar Sesión</h2>
                <div class="icons">
                    <i class='bx bxl-google'></i>
                    <i class='bx bxl-github'></i>
                    <i class='bx bxl-linkedin' ></i>
                </div>
                <p>o Iniciar Sesión con una cuenta</p>
                <form action="./includes/funciones.php" method="post" class="form form-login" novalidate>
                <input type="hidden" name="accion" value="validar">
                    <div>
                        <label >
                            <i class='bx bx-envelope' ></i>
                            <input type="email" placeholder="Correo Electronico" name="UserCorreo">
                        </label>
                    </div>
                    <div>
                        <label>
                            <i class='bx bx-lock-alt' ></i>
                            <input type="password" placeholder="Contraseña" name="UserContraseña">
                        </label>
                    </div>
                    <input type="submit" value="Iniciar Sesión">
                    <div class="alerta-error">Todos los campos son obligatorios</div>
                    <div class="alerta-exito">Te registraste correctamente</div>
                </form>
            </div>
        </div>
    </div>
    <script src="./assets/scripts/script-login.js"></script>
    <script src="./assets/scripts/register.js"></script>
    <script src="./assets/scripts//login.js"></script>
</body>
</html>
