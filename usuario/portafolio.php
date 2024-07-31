<?php
    require('../includes/conexion.php');
    session_start();

    if (!isset($_SESSION['userID'])) 
    {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'CvNest.',
                text: 'Error: No estás autenticado. Redirigiendo...',
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../inicio.php';
                }
            });
        });
        </script>";
        exit();
    }

    $userID = $_SESSION['userID'];
    $conn = Conectar();

    if (isset($_SESSION['message'])) 
    {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Éxito",
                text: "' . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . '",
                icon: "success"
            });
        }); 
        </script>';
        unset($_SESSION['message']);
    }

    function pdf_descargar($conn, $userID) 
    {
        // Consulta para obtener el ID de perfil
        $queryPerfilID = "SELECT IDPerfil FROM usuario WHERE ID_Usuario = ?";
        $stmt = $conn->prepare($queryPerfilID);
        $stmt->bind_param('i', $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) 
        {
            http_response_code(404);
            echo "No se encontró el perfil.";
            return;
        }
        $row = $result->fetch_assoc();
        $perfilID = $row['IDPerfil'];
        $stmt->close();

        // Consulta para obtener el curriculum (PDF) del perfil
        $queryCurriculum = "SELECT Curriculum FROM perfil WHERE ID = ?";
        $stmt = $conn->prepare($queryCurriculum);
        $stmt->bind_param('i', $perfilID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) 
        {
            http_response_code(404); 
            echo "No se encontró el curriculum.";
            return;
        }
        $row = $result->fetch_assoc();
        $curriculum = $row['Curriculum'];
        $stmt->close();

        // Verificar si se obtuvo el archivo y redirigir para la descarga
        if (!empty($curriculum)) 
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="curriculum.pdf"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($curriculum)); 
            echo $curriculum;
            exit();
        } 
        else 
        {
            http_response_code(404); // Not Found
            echo "El archivo no existe.";
        }
    }

    // Manejar la solicitud de descarga
    if (isset($_GET['action']) && $_GET['action'] == 'descargarCV' && isset($_GET['userID'])) 
    {
        $userID = intval($_GET['userID']);
        pdf_descargar($conn, $userID);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $nombre = isset($_POST['Nombre']) ? trim($_POST['Nombre']) : "";
        $correo = isset($_POST['correo']) ? trim($_POST['correo']) : "";
        $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : "";
        $errors = [];
        if (empty($nombre)) {
            $errors[] = "El nombre no puede estar vacío.";
        }
        if (empty($correo)) {
            $errors[] = "El correo no puede estar vacío.";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $correo)) {
            $errors[] = "El correo debe ser un email válido y terminar en @gmail.com.";
        }
        if (empty($mensaje)) {
            $errors[] = "El mensaje no puede estar vacío.";
        } elseif (strlen($mensaje) < 20) {
            $errors[] = "El mensaje debe tener al menos 20 caracteres.";
        }

        if (empty($errors)) 
        {

            $stmt = $conn->prepare("INSERT INTO Mensaje (Nombre, correo, mensaje, ID_Usuario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $nombre, $correo, $mensaje, $userID);
            if ($stmt->execute()) 
            {
                $_SESSION['message'] = "Mensaje enviado exitosamente.";
    
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } 
            else 
            {
                $_SESSION['error'] = "Error al enviar el mensaje: " . $stmt->error;
            }
        } 
        else 
        {
            $_SESSION['errors'] = $errors;
        }
    }

    if (isset($_SESSION['message'])) 
    {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Éxito",
                    text: "' . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . '",
                    icon: "success"
                });
            });
        </script>';
        unset($_SESSION['message']);
    }

    if (isset($_SESSION['errors'])) 
    {
        if (is_array($_SESSION['errors'])) {
            // Concatenar errores con <br> para saltos de línea
            $errors = implode('<br>', $_SESSION['errors']);
        } else {
            $errors = 'Errores desconocidos.';
        }
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Errores",
                    html: "' . htmlspecialchars($errors, ENT_QUOTES, 'UTF-8') . '",
                    icon: "error"
                });
            });
        </script>';
        unset($_SESSION['errors']);
    }

    if (isset($_SESSION['error'])) 
    {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error",
                    text: "' . htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') . '",
                    icon: "error"
                });
            });
        </script>';
        unset($_SESSION['error']);
    }

    $sql = "SELECT pi.ID AS ImagenID, pi.Imagen AS ProyectoImagen, pi.Titulo AS Titulo, pi.GitHub AS GitHub FROM Usuario u
            JOIN Perfil p ON u.IDPerfil = p.ID
            JOIN Proyectos pr ON p.IDProyectos = pr.ID
            JOIN ProyectoImagenes pi ON pi.ProyectoID = pr.ID
            WHERE u.ID_Usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $proyectoImagenesArray = [];
    while ($row = $result->fetch_assoc()) 
    {
        $imagenData = $row['ProyectoImagen'];
        // Verifica si la imagen tiene datos
        if (!empty($imagenData)) {
            $proyectoImagenesArray[] = [
                'id' => $row['ImagenID'],
                'src' => 'data:image/jpeg;base64,' . base64_encode($imagenData),
                'titulo' => $row['Titulo'],
                'github' => $row['GitHub']
            ];
        }
    }

    $sql1 = "SELECT u.ID_Usuario, p.Nombre AS PerfilNombre, e.Colegio, e.Carrera, e.ExperienciaLaboral, e.Especialidad, p.Imagen AS PerfilImagen,  pr.ID AS ProyectoID, pr.GitHub AS ProyectoGitHub,
                GROUP_CONCAT(DISTINCT lp.Lenguaje) AS Lenguajes,
                GROUP_CONCAT(DISTINCT h.Herramienta) AS Herramientas
                FROM Usuario u
                JOIN Perfil p ON u.IDPerfil = p.ID
                JOIN Educacion e ON p.IDEducacion = e.ID
                LEFT JOIN Proyectos pr ON pr.ID = p.IDProyectos
                LEFT JOIN Perfil_Lenguaje pl ON p.ID = pl.PerfilID
                LEFT JOIN Lenguaje_Programacion lp ON pl.LenguajeID = lp.ID
                LEFT JOIN Perfil_Herramientas ph ON p.ID = ph.PerfilID
                LEFT JOIN Herramientas h ON ph.HerramientaID = h.ID
                WHERE u.ID_Usuario = ?
                GROUP BY u.ID_Usuario, p.ID, e.ID, pr.ID";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $userID);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    // Verificar si se obtuvieron resultados
    if ($result1->num_rows > 0) 
    {
        $row1 = $result1->fetch_assoc();
        $perfilNombre = $row1['PerfilNombre'];
        $colegio = $row1['Colegio'];
        $carrera = $row1['Carrera'];
        $experienciaLaboral = $row1['ExperienciaLaboral'];
        $especialidad = $row1['Especialidad'];
        $perfilImagen = $row1['PerfilImagen'];
        $proyectoID = $row1['ProyectoID'];
        $proyectoGitHub = $row1['ProyectoGitHub'];
        $lenguajes = $row1['Lenguajes'];
        $herramientas = $row1['Herramientas'];

        // Convertir la lista de lenguajes y herramientas a arrays
        $lenguajesArray = !empty($lenguajes) ? explode(',', $lenguajes) : [];
        $herramientasArray = !empty($herramientas) ? explode(',', $herramientas) : [];
        // Convertir la imagen del perfil a base64 si existe
        $perfilImagenData = !empty($perfilImagen) ? 'data:image/jpeg;base64,' . base64_encode($perfilImagen) : '';
        // Consulta SQL para obtener las imágenes del proyecto específico
        $sql2 = "SELECT Imagen, Titulo, GitHub FROM ProyectoImagenes WHERE ProyectoID = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $proyectoID);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
    }

    $sql = "SELECT pi.ID AS ImagenID, pi.Imagen AS ProyectoImagen, pi.Titulo AS Titulo, pi.GitHub AS GitHub FROM Usuario u
            JOIN Perfil p ON u.IDPerfil = p.ID
            JOIN Proyectos pr ON p.IDProyectos = pr.ID
            JOIN ProyectoImagenes pi ON pi.ProyectoID = pr.ID
            WHERE u.ID_Usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $proyectoImagenesArray = [];
    while ($row = $result->fetch_assoc()) 
    {
        $imagenData = $row['ProyectoImagen'];
        // Verifica si la imagen tiene datos
        if (!empty($imagenData)) 
        {
            'Data length: ' . strlen($imagenData) . '<br>';
            $proyectoImagenesArray[] = ['id' => $row['ImagenID'], 'src' => 'data:image/jpeg;base64,' . base64_encode($imagenData), 'titulo' => $row['Titulo'], 'github' => $row['GitHub'] ];
        } 
        else { // Debug: Imprime mensaje si la imagen está vacía
        }
    }

    $sql2 = "SELECT p.Gmail AS PerfilGmail, p.Telefono AS PerfilTelefono FROM Usuario u JOIN Perfil p ON u.IDPerfil = p.ID WHERE u.ID_Usuario = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $userID);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows > 0) 
    {
        $row2 = $result2->fetch_assoc(); 
        $perfilGmail2 = $row2['PerfilGmail'];
        $perfilTelefono2 = $row2['PerfilTelefono'];
    } 
    else 
    {
        header("Location: ../includes/sms.php");
        exit();
    }
    $sql2 = "SELECT s.descripcion, s.imagen AS SobreMiImagen FROM sobremi s WHERE s.id_usuario = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $userID);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $descripcion = '';
    $sobreMiImagenData = '';

    if ($result2->num_rows > 0) 
    {
        $row2 = $result2->fetch_assoc();
        $descripcion = $row2['descripcion'];
        $sobreMiImagen = $row2['SobreMiImagen'];
        // Verificar si la imagen está vacía y codificarla en base64
        $sobreMiImagenData = !empty($sobreMiImagen) ? 'data:image/jpeg;base64,' . base64_encode($sobreMiImagen) : '';
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        function descargarCV(userID) 
        {
            // Crear una solicitud AJAX para descargar el PDF
            fetch('?action=descargarCV&userID=' + encodeURIComponent(userID))
                .then(response => {
                    if (response.ok) {
                        return response.blob(); 
                    }
                    throw new Error('Error en la descarga');
                })
                .then(blob => 
                {
                    // Crear una URL para el blob
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'cv_' + userID + '.pdf'; 
                    document.body.appendChild(a);
                    a.click(); 
                    a.remove(); 
                    window.URL.revokeObjectURL(url); 
                })
                .catch(error => 
                {
                    console.error('Hubo un problema con la descarga:', error);
                });
        }
    </script>
    <meta charset="UTF-8" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Mi Portafolio</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/mediaqueries.css" />
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <script>
        function showMessage(type, message) 
        {
            let messageBox = document.createElement('div');
            messageBox.className = 'message ' + type;
            messageBox.textContent = message;
            document.body.insertBefore(messageBox, document.body.firstChild);
        }
    </script>
</head>
<body>
    <nav id="desktop-nav">
        <?php echo '<div class="logo">' . $perfilNombre . '</div>';?>
        <div>
            <ul class="nav-links">
                <li><a href="#about">Acerca de</a></li>
                <li><a href="#experience">Experiencia</a></li>
                <li><a href="#projects">Proyectos</a></li>
                <li><a href="#contact">Contacto</a></li>
                <li><a href="../usuario/inicio.php">Salir</a></li>
            </ul>
        </div>
    </nav>
    <nav id="hamburger-nav">
        <?php echo '<div class="logo">' . $perfilNombre . '</div>';?>
        <div class="hamburger-menu">
            <div class="hamburger-icon" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="menu-links">
                <li><a href="#about" onclick="toggleMenu()">About</a></li>
                <li><a href="#experience" onclick="toggleMenu()">Experience</a></li>
                <li><a href="#projects" onclick="toggleMenu()">Projects</a></li>
                <li><a href="#contact" onclick="toggleMenu()">Contact</a></li>
            </div>
        </div>
    </nav>
    <section id="profile">
        <div class="section__pic-container">
        <img src="<?php echo $perfilImagenData; ?>" alt="John Doe profile picture" />
      </div>
        </div>
        <div class="section__text">
            <p class="section__text__p1">¡Hola!, Soy</p>
            <?php echo '<h1 class="title">' . htmlspecialchars($perfilNombre) . '</h1>';?>
            <p class="section__text__p2"><?php echo htmlspecialchars($especialidad); ?></p>
            <div class="btn-container">
            <button class="btn btn-color-2" onclick="descargarCV('<?php echo htmlspecialchars($userID); ?>')">
                Descargar CV
            </button>
            <button class="btn btn-color-1" onclick="'#contact'">
                <a href="#contact" onclick="toggleMenu()">Contactar</a>
            </button>
            </div>
            <div id="socials-container">
                <img
                    src="../assets/images/portafolio/linkedin.png"
                    alt="Perfil de LinkedIn"
                    class="icon"
                    onclick="location.href='https://linkedin.com/'"
                />
                <img
                    src="../assets/images/portafolio/github.png"
                    alt="Perfil de GitHub"
                    class="icon"
                    onclick="location.href='https://github.com/'"
                />
            </div>
        </div>
    </section>
    <section id="about">
        <p class="section__text__p1">Conozca más</p>
        <h1 class="title">Sobre Mí</h1>
        <div class="section-container">
            <div class="section__pic-container">
                <img
                    src="<?php echo $sobreMiImagenData; ?>"
                    alt="Perfil"
                    class="about-pic"
                />
            </div>
            <div class="about-details-container">
                <div class="about-containers">
                    <div class="details-container">
                        <img
                            src="../assets/images/portafolio/experience.png"
                            alt="Ícono de experiencia"
                            class="icon"
                        />
                        <h3>Experiencia</h3>
                        <p> <?php echo htmlspecialchars($experienciaLaboral); ?><br /><?php echo htmlspecialchars($especialidad); ?> </p>
                    </div>
                    <div class="details-container">
                        <img
                            src="../assets/images/portafolio/education.png"
                            alt="Ícono de educación"
                            class="icon"
                        />
                        <h3>Educación</h3>
                        <p><?php echo htmlspecialchars($colegio); ?><br /><?php echo htmlspecialchars($carrera); ?></p>
                    </div>
                </div>
                <div class="text-container">
                    <p>
                        <p><?php echo htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8'); ?></p>
                    </p>
                </div>
            </div>
        </div>
        <img
            src="../assets/images/portafolio/arrow.png"
            alt="Ícono de flecha"
            class="icon arrow"
            onclick="location.href='#experience'"
        />
    </section>
    <section id="experience">
        <p class="section__text__p1">Explora mi</p>
        <h1 class="title">Experiencia</h1>
        <div class="experience-details-container">
            <div class="about-containers">
                <div class="exp-container">
                    <h2 class="experience-sub-title">Lenguajes de Programación</h2>
                    <div class="article-container">
                        <?php foreach ($lenguajesArray as $lenguaje): ?>
                            <article>
                                <img
                                    src="../assets/images/portafolio/checkmark.png"
                                    alt="Ícono de experiencia"
                                    class="icon"
                                />
                                <div>
                                    <h3><?php echo htmlspecialchars($lenguaje); ?></h3>
                                    <p>Avanzado</p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="exp-container">
                    <h2 class="experience-sub-title">Herramientas</h2>
                    <div class="article-container">
                        <?php foreach ($herramientasArray as $herramienta): ?>
                            <article>
                                <img
                                    src="../assets/images/portafolio/checkmark.png"
                                    alt="Ícono de experiencia"
                                    class="icon"
                                />
                                <div>
                                    <h3><?php echo htmlspecialchars($herramienta); ?></h3>
                                    <p>Basico</p> 
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <img
            src="../assets/images/portafolio/arrow.png"
            alt="Ícono de flecha"
            class="icon arrow"
            onclick="location.href='#projects'"
        />
    </section>
    <section id="projects">
        <p class="section__text__p1">Explorar mis recientes</p>
        <h1 class="title">Proyectos</h1>
        <div class="experience-details-container">
            <div class="about-containers">
                <?php foreach ($proyectoImagenesArray as $proyecto): ?>
                    <div class="details-container color-container">
                        <div class="article-container">
                            <img src="<?php echo htmlspecialchars($proyecto['src']); ?>" alt="<?php echo htmlspecialchars($proyecto['titulo']); ?>" class="project-img" />
                        </div>
                        <h2 class="experience-sub-title project-title"><?php echo htmlspecialchars($proyecto['titulo']); ?></h2>
                        <div class="btn-container">
                            <button class="btn btn-color-2 project-btn" onclick="location.href='<?php echo htmlspecialchars($proyecto['github']); ?>'">
                                Github
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <img
            src="../assets/images/portafolio/arrow.png"
            alt="Arrow icon"
            class="icon arrow"
            onclick="location.href='#contact'"
        />
    </section>
    <section class="section" id="contact">
        <div class="top-header">
            <h1>Ponerse en contacto</h1>
            <span>Tienes algún proyecto en mente, contáctame aquí</span>
        </div>
        <div class="row">
            <div class="col">
                <div class="contact-info">
                    <h2>Encuentrame <i class="uil uil-corner-right-down"></i></h2>
                    <p><i class="uil uil-envelope"></i> <strong>Email:</strong> <?php echo $perfilGmail2 ?></p>
                    <p><i class="uil uil-phone"></i> <strong>Contacto: +591 </strong> <?php echo $perfilTelefono2?></p>
                </div>
            </div>
            <div class="col">
                <form action="#" method="post">
                    <div class="form-control">
                        <div class="form-inputs">
                            <input type="text" class="input-field" placeholder="Nombre" name="Nombre" value="<?php echo htmlspecialchars($_POST['Nombre'] ?? ''); ?>">
                            <input type="text" class="input-field" placeholder="Email" name="correo" value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>">
                        </div>
                        <div class="text-area">
                            <textarea placeholder="Mensaje" name="mensaje"><?php echo htmlspecialchars($_POST['mensaje'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-button">
                            <button class="boton" type="submit" name="submit">Enviar <i class="uil uil-message"></i></button>
                        </div>
                    </div>
                </form>
                <?php
                    if (isset($_SESSION['message'])) {
                        echo '<script>window.onload = function() { showMessage("success", "' . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . '"); }</script>';
                        unset($_SESSION['message']);
                    }

                    if (isset($_SESSION['error'])) {
                        echo '<script>window.onload = function() { showMessage("error", "' . htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') . '"); }</script>';
                        unset($_SESSION['error']);
                    }

                    if (isset($_SESSION['errors'])) {
                        $errors = implode(', ', $_SESSION['errors']);
                        echo '<script>window.onload = function() { showMessage("error", "' . htmlspecialchars($errors, ENT_QUOTES, 'UTF-8') . '"); }</script>';
                        unset($_SESSION['errors']);
                    }
                ?>
            </div>
        </div>
    </section>
    <footer>
        <nav>
            <div class="nav-links-container">
                <ul class="nav-links">
                    <li><a href="#about">Acerca de</a></li>
                    <li><a href="#experience">Experiencia</a></li>
                    <li><a href="#projects">Proyectos</a></li>
                    <li><a href="#contact">Contacto</a></li>
                </ul>
            </div>
        </nav>
        <p>Desarrollado por <img src="../assets/images/index/logo4.png" width="18"> <strong>CVNest. &copy;  2024 </strong> | Todos los derechos reservados</p>
    </footer>
    <script src="../assets/scripts/script.js"></script>
</body>
</html>