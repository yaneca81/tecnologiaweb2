<?php
include_once 'conexion.php';

// Función para obtener todas las ofertas de trabajo
function obtenerOfertas() {
    global $conn;
    $sql = "SELECT * FROM ofertas_trabajo";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($conn);
        return [];
    }

    $ofertas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $ofertas[] = $row;
    }

    return $ofertas;
}

// Función para obtener ofertas de trabajo por empresa
function obtenerOfertasPorEmpresa($id_empresa) {
    global $conn;
    $sql = "SELECT * FROM ofertas_trabajo WHERE id_empresa = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_empresa);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($conn);
        return [];
    }

    $ofertas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $ofertas[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $ofertas;
}

// Función para crear una nueva oferta de trabajo
function crearOferta($id_empresa, $titulo, $descripcion, $requisitos, $fecha, $salario) {
    global $conn;
    $sql = "INSERT INTO ofertas_trabajo (id_empresa, titulo, descripcion, requisitos, fecha, salario) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'issssd', $id_empresa, $titulo, $descripcion, $requisitos, $fecha, $salario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Función para editar una oferta de trabajo existente
function editarOferta($id_oferta, $titulo, $descripcion, $requisitos, $fecha, $salario) {
    global $conn;
    $sql = "UPDATE ofertas_trabajo SET titulo = ?, descripcion = ?, requisitos = ?, fecha = ?, salario = ? WHERE id_oferta = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssdi', $titulo, $descripcion, $requisitos, $fecha, $salario, $id_oferta);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Función para eliminar una oferta de trabajo
function eliminarOferta($id_oferta) {
    global $conn;
    $sql = "DELETE FROM ofertas_trabajo WHERE id_oferta = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_oferta);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Función para autenticar al usuario
function autenticar_usuario($correo, $contraseña) {
    global $conn;
    $sql = "SELECT id_usuario, rol, contraseña FROM usuarios WHERE correo = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $correo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_usuario, $rol, $contraseña_hash);
    
    if (mysqli_stmt_fetch($stmt) && password_verify($contraseña, $contraseña_hash)) {
        mysqli_stmt_close($stmt);
        return [
            'id_usuario' => $id_usuario,
            'rol' => $rol
        ];
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

// Función para obtener el rol del usuario
function obtenerRolUsuario($id_usuario) {
    global $conn;
    $sql = "SELECT rol FROM usuarios WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $rol);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $rol;
}

// Función para registrar un nuevo candidato
function registrarCandidato($correo, $contraseña, $nombre, $apellido, $telefono) {
    global $conn;
    
    // Encriptar la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

    // Insertar en la tabla de usuarios
    $sql = "INSERT INTO usuarios (correo, contraseña, rol) VALUES (?, ?, 'candidato')";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die('Error en la preparación de la consulta: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 'ss', $correo, $contraseña_hash);
    if (!mysqli_stmt_execute($stmt)) {
        die('Error en la ejecución de la consulta: ' . mysqli_stmt_error($stmt));
    }
    $id_usuario = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    // Insertar en la tabla de candidatos
    $sql = "INSERT INTO candidatos (id_usuario, nombre, apellido, telefono) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die('Error en la preparación de la consulta: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 'isss', $id_usuario, $nombre, $apellido, $telefono);
    if (!mysqli_stmt_execute($stmt)) {
        die('Error en la ejecución de la consulta: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);

    return $id_usuario;
}

// Función para registrar una nueva empresa
function registrarEmpresa($correo, $contraseña, $nombre, $direccion, $telefono) {
    global $conn;

    // Encriptar la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

    // Insertar en la tabla de usuarios
    $sql = "INSERT INTO usuarios (correo, contraseña, rol) VALUES (?, ?, 'empresa')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $correo, $contraseña_hash);
    mysqli_stmt_execute($stmt);
    $id_usuario = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    // Insertar en la tabla de empresas
    $sql = "INSERT INTO empresas (id_usuario, nombre, direccion, telefono) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isss', $id_usuario, $nombre, $direccion, $telefono);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $id_usuario;
}

// Función para obtener los detalles de una oferta de trabajo por su ID
function obtenerOfertaPorId($id_oferta) {
    global $conn;
    $sql = "SELECT * FROM ofertas_trabajo WHERE id_oferta = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_oferta);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $oferta = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $oferta;
}

// Función para obtener todas las entrevistas de un candidato
function obtenerEntrevistasCandidato($id_usuario) {
    global $conn;
    $sql = "SELECT e.id_entrevista, o.titulo, em.nombre AS nombre_empresa, e.fecha, e.estado
            FROM entrevistas e
            JOIN ofertas_trabajo o ON e.id_oferta = o.id_oferta
            JOIN empresas em ON o.id_empresa = em.id_empresa
            JOIN candidatos c ON e.id_candidato = c.id_candidato
            WHERE c.id_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $entrevistas = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $entrevistas;
}


function cancelarEntrevista($id_entrevista) {
    global $conn;
    $sql = "DELETE FROM entrevistas WHERE id_entrevista = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_entrevista);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function obtenerIdCandidato($id_usuario) {
    global $conn;
    $sql = "SELECT id_candidato FROM candidatos WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_candidato);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $id_candidato;
}
function obtenerIdEmpresa($id_usuario) {
    global $conn;
    $sql = "SELECT id_empresa FROM empresas WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_empresa);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $id_empresa;
}

?>
