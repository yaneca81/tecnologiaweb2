<link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
<title>CVNest.</title>
<?php
    include 'conexion.php';
    $conn = Conectar();
    // Función para validar imagen
    function validarImg($file) {
        if ($file['error'] === UPLOAD_ERR_OK) 
        {
            $imageInfo = getimagesize($file['tmp_name']);
            if ($imageInfo === false) {
                return "El archivo no es una imagen.";
            }
            // Verifica el tipo de imagen (JPEG, PNG, GIF)
            $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imageInfo['mime'], $validTypes)) {
                return "Tipo de imagen no válido. Se permiten JPEG, PNG y GIF.";
            }
            return null;
        }
        return "Error en la carga de la imagen.";
    }
    // Función para validar currículum
    function validarCurriculum($file) 
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileType = mime_content_type($file['tmp_name']);
            if ($fileType !== 'application/pdf') {
                return "El currículum debe ser un archivo PDF.";
            }
            return null;
        }
        return "Error en la carga del currículum.";
    }
    // Validar datos del formulario
    $errors = [];
    $nombreCompleto = trim($_POST['nombreCompleto']);
    $gmail = trim($_POST['gmail']);
    $telefono = trim($_POST['telefono']);
    $github = trim($_POST['github']);
    $colegio = trim($_POST['colegio']);
    $carrera = trim($_POST['carrera']);
    $experienciaLaboral = trim($_POST['experienciaLaboral']);
    $especialidad = trim($_POST['especialidad']);
    $github1 = trim($_POST['git1']);
    $github2 = trim($_POST['git2']);
    $github3 = trim($_POST['git3']);
    $titulo1 = trim($_POST['proyectoTitulo1']);
    $titulo2 = trim($_POST['proyectoTitulo2']);
    $titulo3 = trim($_POST['proyectoTitulo3']);

    // Validaciones generales
    $errors['nombreCompleto'] = empty($nombreCompleto) ? "El nombre completo es obligatorio." : null;
    $errors['gmail'] = filter_var($gmail, FILTER_VALIDATE_EMAIL) ? null : "El Gmail debe ser una dirección de correo electrónico válida.";
    $errors['telefono'] = preg_match('/^\d{8}$/', $telefono) ? null : "El teléfono debe ser un número entero positivo de exactamente 8 dígitos.";
    $errors['github'] = empty($github) ? "El enlace a GitHub es obligatorio." : null;
    $errors['colegio'] = empty($colegio) ? "El colegio es obligatorio." : null;
    $errors['carrera'] = empty($carrera) ? "La carrera es obligatoria." : null;
    $errors['experienciaLaboral'] = empty($experienciaLaboral) ? "La experiencia laboral es obligatoria." : null;
    $errors['especialidad'] = empty($especialidad) ? "La especialidad es obligatoria." : null;
    $errors['git1'] = empty($github1) ? "El enlace a GitHub del Proyecto 1 es obligatorio." : (filter_var($github1, FILTER_VALIDATE_URL) ? null : "El enlace a GitHub del Proyecto 1 debe ser una URL válida.");
    $errors['git2'] = empty($github2) ? "El enlace a GitHub del Proyecto 2 es obligatorio." : (filter_var($github2, FILTER_VALIDATE_URL) ? null : "El enlace a GitHub del Proyecto 2 debe ser una URL válida.");
    $errors['git3'] = empty($github3) ? "El enlace a GitHub del Proyecto 3 es obligatorio." : (filter_var($github3, FILTER_VALIDATE_URL) ? null : "El enlace a GitHub del Proyecto 3 debe ser una URL válida.");
    $errors['proyectoTitulo1'] = empty($titulo1) ? "El título del Proyecto 1 es obligatorio." : null;
    $errors['proyectoTitulo2'] = empty($titulo2) ? "El título del Proyecto 2 es obligatorio." : null;
    $errors['proyectoTitulo3'] = empty($titulo3) ? "El título del Proyecto 3 es obligatorio." : null;


    // Validar imagen
    $imageError = validarImg($_FILES['imagen']);
    if ($imageError) {
        $errors['imagen'] = $imageError;
    }

    // Validar currículum
    $curriculumError = validarCurriculum($_FILES['curriculum']);
    if ($curriculumError) {
        $errors['curriculum'] = $curriculumError;
    }

    // Validar imágenes de proyecto
    $proyectosImagenErrors = [];
    $proyectosImagen = [];
    if (isset($_FILES['proyectosImagen']) && !empty($_FILES['proyectosImagen']['name'][0])) {
        foreach ($_FILES['proyectosImagen']['name'] as $key => $name) {
            $fileTmpPath = $_FILES['proyectosImagen']['tmp_name'][$key];
            $fileError = $_FILES['proyectosImagen']['error'][$key];

            // Validar imagen
            $fileError = validarImg(['tmp_name' => $fileTmpPath, 'error' => $fileError]);
            if ($fileError) {
                $proyectosImagenErrors[] = "Error en el archivo " . htmlspecialchars($name) . ": " . $fileError;
                continue;
            }

            // Leer el contenido de la imagen
            $proyectosImagen[] = file_get_contents($fileTmpPath);
        }
        if ($proyectosImagenErrors) {
            $errors['proyectosImagen'] = implode('<br>', $proyectosImagenErrors);
        }
    } else {
        $errors['proyectosImagen'] = "No se seleccionaron imágenes.";
    }
    // Definir lenguajes de programación válidos
    $programacionLenguajes = [
        ['value' => 'javascript', 'label' => 'JavaScript'],
        ['value' => 'python', 'label' => 'Python'],
        ['value' => 'java', 'label' => 'Java'],
        ['value' => 'csharp', 'label' => 'C#'],
        ['value' => 'cpp', 'label' => 'C++'],
        ['value' => 'ruby', 'label' => 'Ruby'],
        ['value' => 'php', 'label' => 'PHP'],
        ['value' => 'typescript', 'label' => 'TypeScript'],
        ['value' => 'go', 'label' => 'Go'],
        ['value' => 'rust', 'label' => 'Rust'],
        ['value' => 'swift', 'label' => 'Swift'],
        ['value' => 'kotlin', 'label' => 'Kotlin'],
        ['value' => 'scala', 'label' => 'Scala'],
        ['value' => 'haskell', 'label' => 'Haskell'],
        ['value' => 'perl', 'label' => 'Perl'],
        ['value' => 'lua', 'label' => 'Lua'],
        ['value' => 'r', 'label' => 'R'],
        ['value' => 'objective-c', 'label' => 'Objective-C'],
        ['value' => 'dart', 'label' => 'Dart'],
        ['value' => 'shell', 'label' => 'Shell Script']
    ];

    $herramientas = [
        ['value' => 'postgresql', 'label' => 'PostgreSQL (Básico)'],
        ['value' => 'nodejs', 'label' => 'Node.js (Intermedio)'],
        ['value' => 'expressjs', 'label' => 'Express.js (Intermedio)'],
        ['value' => 'git', 'label' => 'Git (Intermedio)'],
        ['value' => 'mongodb', 'label' => 'MongoDB (Básico)'],
        ['value' => 'mysql', 'label' => 'MySQL (Básico)'],
        ['value' => 'docker', 'label' => 'Docker (Básico)'],
        ['value' => 'kubernetes', 'label' => 'Kubernetes (Básico)'],
        ['value' => 'java', 'label' => 'Java (Intermedio)'],
        ['value' => 'spring', 'label' => 'Spring Framework (Básico)'],
        ['value' => 'python', 'label' => 'Python (Intermedio)'],
        ['value' => 'django', 'label' => 'Django (Básico)'],
        ['value' => 'html', 'label' => 'HTML (Avanzado)'],
        ['value' => 'css', 'label' => 'CSS (Avanzado)'],
        ['value' => 'javascript', 'label' => 'JavaScript (Intermedio)'],
        ['value' => 'typescript', 'label' => 'TypeScript (Básico)'],
        ['value' => 'react', 'label' => 'React (Intermedio)'],
        ['value' => 'vue', 'label' => 'Vue.js (Básico)'],
        ['value' => 'angular', 'label' => 'Angular (Básico)'],
        ['value' => 'aws', 'label' => 'AWS (Básico)'],
        ['value' => 'azure', 'label' => 'Azure (Básico)'],
        ['value' => 'jira', 'label' => 'Jira (Intermedio)'],
        ['value' => 'webpack', 'label' => 'Webpack (Básico)'],
        ['value' => 'babel', 'label' => 'Babel (Básico)']
    ];

    // Validar lenguajes de programación
    $lenguajes = $_POST['lenguajes'] ?? [];
    $nivelesLenguaje = $_POST['nivelesLenguaje'] ?? [];
    foreach ($lenguajes as $index => $lenguaje) {
        // Validar que el lenguaje seleccionado sea uno de los válidos
        $validLang = array_column($programacionLenguajes, 'value');
        $errors["lenguaje_$index"] = in_array($lenguaje, $validLang) ? null : "El lenguaje de programación seleccionado no es válido.";

        // Validar que el nivel del lenguaje esté presente
        $errors["nivelLenguaje_$index"] = empty($nivelesLenguaje[$index]) ? "El nivel del lenguaje de programación es obligatorio." : null;
    }

    // Validar herramientas
    $herramientas = $_POST['herramientas'] ?? [];
    $nivelesHerramienta = $_POST['nivelesHerramienta'] ?? [];
    foreach ($herramientas as $index => $herramienta) {
        // Validar que la herramienta seleccionada sea una de las válidas
        $validTools = array_column($herramientas, 'value');
        $errors["herramienta_$index"] = in_array($herramienta, $validTools) ? null : "La herramienta seleccionada no es válida.";

        // Validar que el nivel de la herramienta esté presente
        $errors["nivelHerramienta_$index"] = empty($nivelesHerramienta[$index]) ? "El nivel de la herramienta es obligatorio." : null;
    }


    // Verificar si hay errores
    if (array_filter($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        header('Location: ../usuario/perfil.php');
        exit;
    }

        // Insertar el proyecto y obtener el ID
        $sql = "INSERT INTO Proyectos (GitHub) VALUES (?)";
        if (!$stmt = $conn->prepare($sql)) {
            die('Error al preparar la consulta de proyectos: ' . $conn->error);
        }
        $stmt->bind_param('s', $github);
        $stmt->execute();
        $idProyecto = $conn->insert_id;

        // Insertar imágenes de proyectos con título y GitHub
        if (!empty($_FILES['proyectosImagen']['name'][0])) {
            $sqlImagenes = "INSERT INTO ProyectoImagenes (ProyectoID, imagen, Titulo, GitHub) VALUES (?, ?, ?, ?)";
            if (!$stmtImagenes = $conn->prepare($sqlImagenes)) {
                die('Error al preparar la consulta de imágenes de proyectos: ' . $conn->error);
            }

            // Iterar sobre las imágenes y los títulos
            for ($i = 0; $i < 3; $i++) 
            {
                $imagenTmp = $_FILES['proyectosImagen']['tmp_name'][$i];
                $titulo = trim($_POST["proyectoTitulo" . ($i + 1)]);
                $githubUrl = trim($_POST["git" . ($i + 1)]);
                if (!empty($imagenTmp) && !empty($titulo) && !empty($githubUrl)) {
                    $imagen = file_get_contents($imagenTmp);
                    $stmtImagenes->bind_param('ibss', $idProyecto, $imagen, $titulo, $githubUrl);
                    $stmtImagenes->send_long_data(1, $imagen);
                    $stmtImagenes->execute();
                }
            }
        }

    // Insertar Educación
    $sql = "INSERT INTO Educacion (Colegio, Carrera, ExperienciaLaboral, Especialidad) VALUES (?, ?, ?, ?)";
    if (!$stmt = $conn->prepare($sql))
    {
        die('Error al preparar la consulta de educación: ' . $conn->error);
    }
    $stmt->bind_param('ssss', $colegio, $carrera, $experienciaLaboral, $especialidad);
    $stmt->execute();
    $idEducacion = $conn->insert_id;

    // Insertar Perfil
    $sql = "INSERT INTO Perfil (Nombre, Imagen, Curriculum, Gmail, Telefono, IDProyectos, IDEducacion) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $imagenBlob = file_get_contents($_FILES['imagen']['tmp_name']);
    $curriculumBlob = file_get_contents($_FILES['curriculum']['tmp_name']);
    if (!$stmt = $conn->prepare($sql)) 
    {
        die('Error al preparar la consulta de perfil: ' . $conn->error);
    }
    $stmt->bind_param(
        'sssssii', // Ajusta según los tipos
        $nombreCompleto, 
        $imagenBlob, 
        $curriculumBlob, 
        $gmail, 
        $telefono, 
        $idProyecto, 
        $idEducacion
    );
    $stmt->execute();
    $idPerfil = $conn->insert_id;
    // Insertar Niveles de Lenguaje si no existen
    foreach ($nivelesLenguaje as $nivel) 
    {
        $sql = "INSERT IGNORE INTO Nivel_Lenguaje (Nivel) VALUES (?)";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de niveles de lenguaje: ' . $conn->error);
        }
        $stmt->bind_param('s', $nivel);
        $stmt->execute();
    }

    // Insertar Lenguajes de Programación y asociar con Perfil
    foreach ($lenguajes as $index => $lenguaje) 
    {
        $nivel = $nivelesLenguaje[$index];
        // Verifica si el nivel existe y obtiene su ID
        $sql = "SELECT ID FROM Nivel_Lenguaje WHERE Nivel = ?";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de niveles de lenguaje: ' . $conn->error);
        }
        $stmt->bind_param('s', $nivel);
        $stmt->execute();
        $result = $stmt->get_result();
        $nivelID = $result->fetch_assoc()['ID'] ?? null;
        // Insertar el lenguaje si no existe
        $sql = "INSERT IGNORE INTO Lenguaje_Programacion (Lenguaje) VALUES (?)";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de lenguajes de programación: ' . $conn->error);
        }
        $stmt->bind_param('s', $lenguaje);
        $stmt->execute();
        $lenguajeID = $conn->insert_id;
        // Insertar en Perfil_Lenguaje
        $sql = "INSERT INTO perfil_lenguaje (PerfilID, LenguajeID) VALUES (?, ?)";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de perfil_lenguaje: ' . $conn->error);
        }
        $stmt->bind_param('ii', $idPerfil, $lenguajeID);
        $stmt->execute();
    }

    // Insertar Niveles de Herramienta si no existen
    foreach ($nivelesHerramienta as $nivel) 
    {
        $sql = "INSERT IGNORE INTO Nivel_Herramientas (Nivel) VALUES (?)";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de niveles de herramienta: ' . $conn->error);
        }
        $stmt->bind_param('s', $nivel);
        $stmt->execute();
    }

    // Insertar Herramientas y asociar con Perfil
    foreach ($herramientas as $index => $herramienta) 
    {
        $nivel = $nivelesHerramienta[$index];
        // Verifica si el nivel existe y obtiene su ID
        $sql = "SELECT ID FROM Nivel_Herramientas WHERE Nivel = ?";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de niveles de herramienta: ' . $conn->error);
        }
        $stmt->bind_param('s', $nivel);
        $stmt->execute();
        $result = $stmt->get_result();
        $nivelID = $result->fetch_assoc()['ID'] ?? null;
        // Insertar la herramienta si no existe
        $sql = "INSERT IGNORE INTO Herramientas (Herramienta) VALUES (?)";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de herramientas: ' . $conn->error);
        }
        $stmt->bind_param('s', $herramienta);
        $stmt->execute();
        $herramientaID = $conn->insert_id;
        // Insertar en Perfil_Herramientas
        $sql = "INSERT INTO perfil_herramientas (PerfilID, HerramientaID) VALUES (?, ?)";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de perfil_herramientas: ' . $conn->error);
        }
        $stmt->bind_param('ii', $idPerfil, $herramientaID);
        $stmt->execute();
    }

    // Insertar Niveles de Herramienta si no existen
    foreach ($nivelesHerramienta as $nivel) 
    {
        $sql = "INSERT IGNORE INTO Nivel_Herramientas (Nivel) VALUES (?)";
        if (!$stmt = $conn->prepare($sql)) {
            die('Error al preparar la consulta de niveles de herramienta: ' . $conn->error);
        }
        $stmt->bind_param('s', $nivel);
        $stmt->execute();
    }

    // Insertar Herramientas y asociar con Perfil
    foreach ($herramientas as $index => $herramienta) 
    {
        $nivel = $nivelesHerramienta[$index];
        // Verifica si el nivel existe y obtiene su ID
        $sql = "SELECT ID FROM Nivel_Herramientas WHERE Nivel = ?";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de niveles de herramienta: ' . $conn->error);
        }
        $stmt->bind_param('s', $nivel);
        $stmt->execute();
        $result = $stmt->get_result();
        $nivelID = $result->fetch_assoc()['ID'] ?? null;
        // Insertar la herramienta si no existe
        $sql = "INSERT IGNORE INTO Herramientas (Herramienta) VALUES (?)";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de herramientas: ' . $conn->error);
        }
        $stmt->bind_param('s', $herramienta);
        $stmt->execute();
        $herramientaID = $conn->insert_id;
        // Insertar en Perfil_Herramientas
        $sql = "INSERT INTO perfil_herramientas (PerfilID, HerramientaID) VALUES (?, ?)";
        if (!$stmt = $conn->prepare($sql)) 
        {
            die('Error al preparar la consulta de perfil_herramientas: ' . $conn->error);
        }
        $stmt->bind_param('ii', $idPerfil, $herramientaID);
        $stmt->execute();
    }

    function unir_usaurio()
    {
        global $conn;
        $sql = "SELECT MAX(ID) AS max_id FROM perfil";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            // Obtener el ID más alto
            $row = $result->fetch_assoc();
            $max_id = $row['max_id'];
        }
        return $max_id;
    }
    $max_id=unir_usaurio();
    // Redirigir a la página de perfil
    session_start();
    $usuarioid = $_SESSION['userID'];
    $mysql = "UPDATE usuario SET IDPerfil = ? WHERE ID_Usuario = ?";
    $stmt = $conn->prepare($mysql);
    $stmt->bind_param("ii", $max_id, $usuarioid);
    $stmt->execute();
    //tabla sobremi
    $descripcion=$_POST['descripcion'];
    if (isset($_FILES['imgmi']) && $_FILES['imgmi']['error'] === UPLOAD_ERR_OK) 
    {
        // Leer el archivo de imagen
        $img = file_get_contents($_FILES['imgmi']['tmp_name']);
    }
    $stmt = $conn->prepare("INSERT INTO sobremi (descripcion, imagen, id_usuario) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $descripcion, $img, $usuarioid);
    $stmt->execute();
    $_SESSION['message'] = 'Perfil creado exitosamente';
    header('Location: ../usuario/portafolio.php');
    exit();
?>