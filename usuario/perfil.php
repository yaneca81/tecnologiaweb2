<?php
    session_start();
    if (isset($_SESSION['errors'])) 
    {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
    } 
    else 
    {
        $errors = [];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <title>Creación del Perfil</title>
    <script>
        function removerElemento(button) 
        {
            button.parentElement.remove();
        }
        const programacionLenguajes = 
        [
            { value: 'javascript', label: 'JavaScript' },
            { value: 'python', label: 'Python' },
            { value: 'java', label: 'Java' },
            { value: 'csharp', label: 'C#' },
            { value: 'cpp', label: 'C++' },
            { value: 'ruby', label: 'Ruby' },
            { value: 'php', label: 'PHP' },
            { value: 'typescript', label: 'TypeScript' },
            { value: 'go', label: 'Go' },
            { value: 'rust', label: 'Rust' },
            { value: 'swift', label: 'Swift' },
            { value: 'kotlin', label: 'Kotlin' },
            { value: 'scala', label: 'Scala' },
            { value: 'haskell', label: 'Haskell' },
            { value: 'perl', label: 'Perl' },
            { value: 'lua', label: 'Lua' },
            { value: 'r', label: 'R' },
            { value: 'objective-c', label: 'Objective-C' },
            { value: 'dart', label: 'Dart' },
            { value: 'shell', label: 'Shell Script' }
            ];

        const herramientas = 
        [
            { value: 'postgresql', label: 'PostgreSQL' },
            { value: 'nodejs', label: 'Node.js' },
            { value: 'expressjs', label: 'Express.js' },
            { value: 'git', label: 'Git' },
            { value: 'mongodb', label: 'MongoDB' },
            { value: 'mysql', label: 'MySQL' },
            { value: 'docker', label: 'Docker' },
            { value: 'kubernetes', label: 'Kubernetes' },
            { value: 'java', label: 'Java' },
            { value: 'spring', label: 'Spring Framework' },
            { value: 'python', label: 'Python' },
            { value: 'django', label: 'Django' },
            { value: 'html', label: 'HTML' },
            { value: 'css', label: 'CSS' },
            { value: 'javascript', label: 'JavaScript' },
            { value: 'typescript', label: 'TypeScript' },
            { value: 'react', label: 'React' },
            { value: 'vue', label: 'Vue.js' },
            { value: 'angular', label: 'Angular' },
            { value: 'aws', label: 'AWS' },
            { value: 'azure', label: 'Azure' },
            { value: 'jira', label: 'Jira' },
            { value: 'webpack', label: 'Webpack' },
            { value: 'babel', label: 'Babel' }
        ];

        function crearOpciones(options) 
        {
            return options.map(option => `<option value="${option.value}">${option.label}</option>`).join('');
        }

        function añadirLenguaje() 
        {
            let index = document.querySelectorAll('#lenguajes > div').length;
            let div = document.createElement('div');
            div.innerHTML = `
                <label for="lenguaje_${index}">Lenguaje:</label>
                <select id="lenguaje_${index}" name="lenguajes[]" required>
                    ${crearOpciones(programacionLenguajes)}
                </select>
                <label for="nivelLenguaje_${index}">Nivel:</label>
                <select id="nivelLenguaje_${index}" name="nivelesLenguaje[]" required>
                    <option value="1">Básico</option>
                    <option value="2">Intermedio</option>
                    <option value="3">Avanzado</option>
                </select>
                <button type="button" class="button-remove" onclick="removerElemento(this)"><i class="fa-solid fa-trash"></i> Eliminar</button><br>
            `;
            document.getElementById('lenguajes').appendChild(div);
        }

        function añadirHerramienta() 
        {
            let index = document.querySelectorAll('#herramientas > div').length;
            let div = document.createElement('div');
            div.innerHTML = `
                <label for="herramienta_${index}">Herramienta:</label>
                <select id="herramienta_${index}" name="herramientas[]" required>
                    ${crearOpciones(herramientas)}
                </select>
                <label for="nivelHerramienta_${index}">Nivel:</label>
                <select id="nivelHerramienta_${index}" name="nivelesHerramienta[]" required>
                    <option value="1">Básico</option>
                    <option value="2">Intermedio</option>
                    <option value="3">Avanzado</option>
                </select>
                <button type="button" class="button-remove" onclick="removerElemento(this)"><i class="fa-solid fa-trash"></i> Eliminar</button><br>
            `;
            document.getElementById('herramientas').appendChild(div);
        }

        function agregarImg() 
        {
            let index = document.querySelectorAll('#imagenesContainer > div').length + 1;
            let div = document.createElement('div');
            div.innerHTML = `
                <label for="proyectoImagen_${index}">Imagen del Proyecto ${index}:</label>
                <input type="file" id="proyectoImagen_${index}" name="proyectosImagen[]" accept="image/*">
                <button type="button" class="button-remove" onclick="removerElemento(this)"><i class="fa-solid fa-trash"></i> Eliminar</button><br>
            `;
            document.getElementById('imagenesContainer').appendChild(div);
        }

        function removerElemento(button) 
        {
            button.parentElement.remove();
        }

        function ImagenPrevia(event, previewId, fileChosenId) 
        {
            const reader = new FileReader();
            
            reader.onload = function() {
                const preview = document.getElementById(previewId);
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
                const fileName = event.target.files[0].name;
                const fileChosen = document.getElementById(fileChosenId);
                fileChosen.textContent = fileName;
            }
        }

        function MostrarArchivo(input) 
        {  
            var fileNameContainer = document.getElementById('file-name-container');  
            if (input.files && input.files[0]) {  
                var file = input.files[0];  
                var fileName = file.name;  
                var fileURL = URL.createObjectURL(file);  
                fileNameContainer.innerHTML = `  
                    <i class="fa-solid fa-file-lines" style="color:white; margin-right:5px;"></i>  
                    <a href="${fileURL}" target="_blank" onclick="event.stopPropagation();">${fileName}</a>  
                `;  
                fileNameContainer.style.display = 'block';  
            } else {  
                fileNameContainer.innerHTML = '';  
                fileNameContainer.style.display = 'none';  
            }  

        }
    </script>
</head>
<body>
    <img src="../assets/images/portafolio/banner.jpg" alt="Encabezado" class="header-image">
    <nav>
        <ul>
            <li><a href="#perfil">Perfil</a></li>
            <li><a href="#sobre">Sobre Mí</a></li>
            <li><a href="#proyectos">Proyectos</a></li>
            <li><a href="#educacion">Educación</a></li>
            <li><a href="#lenguaje">Lenguajes de Programación</a></li>
            <li><a href="#herramienta">Herramientas</a></li>
        </ul>
    </nav>
    <main>
        <form action="../includes/validacion.php" method="POST" enctype="multipart/form-data">
            <div class="card" id="perfil">
                <div class="header-section">
                    <img src="../assets/images/portafolio/icon-user.png" alt="Logo" class="logo-header">
                    <h2>Sección N°1:</h2><h3>Perfil</h3>
                </div>
                <p>Completa tu perfil personal con información básica que incluye tu nombre completo, una foto de perfil, tu currículum y detalles de contacto. Estos datos son fundamentales para que otros puedan conocerte mejor y contactarte si es necesario.</p>
                <div class="form-container">
                    <label for="nombreCompleto">Nombre Completo:</label>
                    <input type="text" id="nombreCompleto" name="nombreCompleto" value="<?php echo isset($_POST['nombreCompleto']) ? htmlspecialchars($_POST['nombreCompleto']) : ''; ?>">
                    <?php if (isset($errors['nombreCompleto'])): ?>
                        <span style="color: red;"><?php echo $errors['nombreCompleto']; ?></span>
                    <?php endif; ?>
                    
                    <!-- Selector para la primera imagen -->
                    <label for="imagen">Imagen:</label>
                    <img id="preview-imagen" src="#" alt="Vista previa de la imagen" style="display: none;">
                    <div class="custom-file-upload">
                        <button type="button" onclick="document.getElementById('imagen').click();">
                            <i class="fa-solid fa-image"></i> Seleccionar imagen
                        </button>
                        <span id="file-chosen-imagen" style="margin-left: 15px;">Ningún archivo seleccionado</span>
                    </div>
                    <input type="file" id="imagen" name="imagen" accept="image/*" style="display: none;" onchange="ImagenPrevia(event, 'preview-imagen', 'file-chosen-imagen')">
                    <?php if (isset($errors['imagen'])): ?>
                        <span style="color: red;"><?php echo htmlspecialchars($errors['imagen']); ?></span>
                    <?php endif; ?>
                    <br>
                    <label for="curriculum" class="file-label">Curriculum:</label>  
                    <div id="file-name-container" class="file-name-container"></div>  
                    <div class="file-container">  
                        <button type="button" class="file-button" onclick="document.getElementById('curriculum').click();">  
                            <i class="fa-solid fa-file-pdf"></i> Elegir Archivo  
                        </button>  
                        <input type="file" id="curriculum" name="curriculum" class="file-input" onchange="MostrarArchivo(this)" style="display: none;">  
                    </div>
                    <?php if (isset($errors['curriculum'])): ?>
                        <span style="color: red;"><?php echo $errors['curriculum']; ?></span>
                    <?php endif; ?>
                    <br>
                    <label for="gmail">Gmail:</label>
                    <input type="email" id="gmail" name="gmail" value="<?php echo isset($_POST['gmail']) ? htmlspecialchars($_POST['gmail']) : ''; ?>">
                    <?php if (isset($errors['gmail'])): ?>
                        <span style="color: red;"><?php echo $errors['gmail']; ?></span>
                    <?php endif; ?>

                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
                    <?php if (isset($errors['telefono'])): ?>
                        <span style="color: red;"><?php echo $errors['telefono']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card" id="sobre">
                <div class="header-section">
                    <img src="../assets/images/portafolio/icon-sobre.png" alt="Logo" class="logo-header">
                    <h2>Sección N°2:</h2><h3>Sobre Mí</h3>
                </div>                    
                <p>Esta sección es tu oportunidad para presentarte de manera más personal. Añade una foto personal y proporciona una descripción breve sobre ti, incluyendo tus intereses y motivaciones profesionales.</p>
                <div class="form-container">
                <label for="imgmi">Foto Personal:</label>
                <img id="preview-imgmi" src="#" alt="Vista previa de la foto personal" style="display: none;">
                <div class="custom-file-upload">
                        <button type="button" onclick="document.getElementById('imgmi').click();">
                            <i class="fa-solid fa-image"></i> Seleccionar imagen
                        </button>
                        <span id="file-chosen-imagen" style="margin-left: 15px;">Ningún archivo seleccionado</span>
                </div>
                <br>
                <input type="file" id="imgmi" name="imgmi" style="display: none;" onchange="ImagenPrevia(event, 'preview-imgmi', 'file-chosen-imgmi')">

                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion">
                </div>
            </div>

            <div class="card" id="proyectos">
                <div class="header-section">
                    <img src="../assets/images/portafolio/icon-proyecto.png" alt="Logo" class="logo-header">
                    <h2>Sección N°3:</h2><h3>Proyectos</h3>
                </div>                    
                <p>Aquí puedes mostrar tus proyectos más destacados. Proporciona detalles sobre cada proyecto, incluyendo una imagen representativa y un enlace a tu repositorio en GitHub para que otros puedan ver el código y detalles técnicos.</p>
                <div class="form-container">
                    <div id="imagenesContainer" class="images-container">
                        <div>
                            <h1>Proyecto N°1</h1>
                            <label for="proyectoTitulo_1">Título del Proyecto :</label>
                            <input type="text" id="proyectoTitulo_1" name="proyectoTitulo1"><br><br>
                            <?php if (isset($errors['proyectoTitulo1'])): ?>
                                <span style="color: red;"><?php echo $errors['proyectoTitulo1']; ?></span>
                            <?php endif; ?>
                    
                            <label for="proyectoImagen_1">Imagen del Proyecto:</label>
                            <img id="preview-proyectoImagen_1" src="#" alt="Vista previa de la imagen del proyecto" style="display: none;">
                            <div class="custom-file-upload">
                                    <button type="button" onclick="document.getElementById('proyectoImagen_1').click();">
                                        <i class="fa-solid fa-image"></i> Seleccionar imagen
                                    </button>
                                    <span id="file-chosen-imagen" style="margin-left: 15px;">Ningún archivo seleccionado</span>
                            </div>
                            <input type="file" id="proyectoImagen_1" name="proyectosImagen[]" style="display: none;" accept="image/*" onchange="ImagenPrevia(event, 'preview-proyectoImagen_1', 'file-chosen-proyectoImagen_1')">
                            <br>

                            <label for="git1">Enlace GitHub:</label>
                            <input type="text" id="git1" name="git1"><br><br>
                            <?php if (isset($errors['git1'])): ?>
                                <span style="color: red;"><?php echo $errors['git1']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h1>Proyecto N°2</h1>
                            <label for="proyectoTitulo_2">Título del Proyecto:</label>
                            <input type="text" id="proyectoTitulo_2" name="proyectoTitulo2"><br><br>
                            <?php if (isset($errors['proyectoTitulo2'])): ?>
                                <span style="color: red;"><?php echo $errors['proyectoTitulo2']; ?></span>
                            <?php endif; ?>
                            
                            <label for="proyectoImagen_2">Imagen del Proyecto 2:</label>
                            <img id="preview-proyectoImagen_2" src="#" alt="Vista previa de la imagen del proyecto 2" style="display: none;">
                            <div class="custom-file-upload">
                                <button type="button" onclick="document.getElementById('proyectoImagen_2').click();" class="upload-button">
                                    <i class="fa-solid fa-image"></i> Seleccionar imagen 
                                </button>
                                <span id="file-chosen-proyectoImagen_2" class="file-chosen" style="margin-left: 15px;">Ningún archivo seleccionado</span>
                            </div>
                            <input type="file" id="proyectoImagen_2" name="proyectosImagen[]" style="display: none;" accept="image/*" onchange="ImagenPrevia(event, 'preview-proyectoImagen_2', 'file-chosen-proyectoImagen_2')">
                            
                            <br>
                            <label for="git2">Enlace GitHub:</label>
                            <input type="text" id="git2" name="git2"><br><br>
                            <?php if (isset($errors['git2'])): ?>
                                <span style="color: red;"><?php echo $errors['git2']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h1>Proyecto N°3</h1>
                            <label for="proyectoTitulo_3">Título del Proyecto:</label>
                            <input type="text" id="proyectoTitulo_3" name="proyectoTitulo3"><br><br>
                            <?php if (isset($errors['proyectoTitulo3'])): ?>
                                <span style="color: red;"><?php echo $errors['proyectoTitulo3']; ?></span>
                            <?php endif; ?>
                            
                            <label for="proyectoImagen_3">Imagen del Proyecto 3:</label>
                            <img id="preview-proyectoImagen_3" src="#" alt="Vista previa de la imagen del proyecto 3" style="display: none;">
                            <div class="custom-file-upload">
                                <button type="button" onclick="document.getElementById('proyectoImagen_3').click();" class="upload-button">
                                    <i class="fa-solid fa-image"></i> Seleccionar imagen
                                </button>
                                <span id="file-chosen-proyectoImagen_3" class="file-chosen" style="margin-left: 15px;">Ningún archivo seleccionado</span>
                            </div>
                            <input type="file" id="proyectoImagen_3" name="proyectosImagen[]" style="display: none;" accept="image/*" onchange="ImagenPrevia(event, 'preview-proyectoImagen_3', 'file-chosen-proyectoImagen_3')">
                            <br>

                            <label for="git3">Enlace GitHub:</label>
                            <input type="text" id="git3" name="git3"><br><br>
                            <?php if (isset($errors['git3'])): ?>
                                <span style="color: red;"><?php echo $errors['git3']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <input type="hidden" id="github" name="github" value="https://github.com/">
                    <button type="button" class="button-add" onclick="agregarImg()"><i class="fa-duotone fa-solid fa-circle-plus"></i> Agregar Proyecto</button><br><br>
                    <?php if (isset($errors['github'])): ?>
                        <span style="color: red;"><?php echo $errors['github']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card" id="educacion">
                <div class="header-section">
                    <img src="../assets/images/portafolio/icon-estudio.png" alt="Logo" class="logo-header">
                    <h2>Sección N°4:</h2><h3>Educación</h3>
                </div>
                <p>En esta sección, proporciona información sobre tu formación académica, incluyendo tu educación formal y cualquier otra formación relevante que hayas completado.</p>
                <div class="form-container">
                    <label for="colegio">Colegio:</label>
                    <input type="text" id="colegio" name="colegio" value="<?php echo isset($_POST['colegio']) ? htmlspecialchars($_POST['colegio']) : ''; ?>">
                    <?php if (isset($errors['colegio'])): ?>
                        <span style="color: red;"><?php echo $errors['colegio']; ?></span>
                    <?php endif; ?>

                    <label for="carrera">Carrera:</label>
                    <input type="text" id="carrera" name="carrera" value="<?php echo isset($_POST['carrera']) ? htmlspecialchars($_POST['carrera']) : ''; ?>">
                    <?php if (isset($errors['carrera'])): ?>
                        <span style="color: red;"><?php echo $errors['carrera']; ?></span>
                    <?php endif; ?>

                    <label for="experienciaLaboral">Experiencia Laboral:</label>
                    <input type="text" id="experienciaLaboral" name="experienciaLaboral" value="<?php echo isset($_POST['experienciaLaboral']) ? htmlspecialchars($_POST['experienciaLaboral']) : ''; ?>">
                    <?php if (isset($errors['experienciaLaboral'])): ?>
                        <span style="color: red;"><?php echo $errors['experienciaLaboral']; ?></span>
                    <?php endif; ?>

                    <label for="especialidad">Especialidad:</label>
                    <input type="text" id="especialidad" name="especialidad" value="<?php echo isset($_POST['especialidad']) ? htmlspecialchars($_POST['especialidad']) : ''; ?>">
                    <?php if (isset($errors['especialidad'])): ?>
                        <span style="color: red;"><?php echo $errors['especialidad']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card" id="lenguaje">
                <div class="header-section">
                    <img src="../assets/images/portafolio/icon-codigo.png" alt="Logo" class="logo-header">
                    <h2>Sección N°5:</h2><h3>Lenguajes de Programación</h3>
                </div>
                <p>Aquí puedes listar los lenguajes de programación que dominas. Esto ayudará a otros a entender mejor tus habilidades técnicas.</p>
                <div class="form-container">
                    <div id="lenguajes">
                        <!-- Campos -->
                    </div>
                    <button type="button" class="button-add" onclick="añadirLenguaje()"><i class="fa-duotone fa-solid fa-circle-plus"></i> Agregar Lenguaje</button><br><br>
                </div>
            </div>

            <div class="card" id="herramienta">
                <div class="header-section">
                    <img src="../assets/images/portafolio/icon-herramienta.png" alt="Logo" class="logo-header">
                    <h2>Sección N°6:</h2><h3>Herramientas</h3>
                </div>
                <p>Enumera las herramientas y tecnologías que usas en tu trabajo diario. Esto puede incluir software, frameworks, o cualquier otra herramienta que sea relevante para tu desarrollo profesional.</p>
                <div class="form-container">
                    <div id="herramientas">
                        <!-- Campos -->
                    </div>
                    <button type="button" class="button-add" onclick="añadirHerramienta()"><i class="fa-duotone fa-solid fa-circle-plus"></i> Agregar Herramienta</button><br><br>
                    </div>
            </div>
            <div class="button-container">
                <button type="submit" class="button-env"><i class="fas fa-paper-plane"></i> Enviar</button>
            </div>            
        </form>
    </main>
</body>
</html>