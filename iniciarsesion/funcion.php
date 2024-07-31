<?php
function verificarLogin($correo, $contrasena, $conn) {
    $query = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['usuario'] = $usuario['correo'];
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
                return true;
            } else {
                return false; // Contraseña incorrecta
            }
        } else {
            return false; // Usuario no encontrado
        }
    } else {
        throw new Exception("Error en la base de datos.");
    }
}
?>
