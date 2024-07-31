<?php
require 'includes/conexion.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = conectar();

    // Verificar si la conexión fue exitosa
    if ($conn === false) {
        die("Error en la conexión: " . mysqli_connect_error());
    }

    // Consulta para obtener los datos del usuario
    $sql = "SELECT u.Id, u.Correo, u.Contraseña, 
                   (SELECT 'Administrador' FROM administrador WHERE Id_usuario = u.Id) as RolAdmin,
                   (SELECT 'Profesor' FROM profesor WHERE Id_persona = u.Id_persona) as RolProfesor,
                   (SELECT 'Estudiante' FROM estudiante WHERE Id_persona = u.Id_persona) as RolEstudiante,
                   (SELECT 'Tutor' FROM tutor WHERE Id_usuario = u.Id) as RolTutor
            FROM usuario u
            WHERE u.Correo = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $user_username, $user_password, $role_admin, $role_profesor, $role_estudiante, $role_tutor);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Determinar el rol del usuario
    $user_role = $role_admin ?: $role_profesor ?: $role_estudiante ?: $role_tutor;

    // Verificar si se encontró el usuario y la contraseña es correcta
    if ($user_username && $password === $user_password) {
        // Guardar los datos del usuario en la sesión
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user_username;
        $_SESSION['role'] = $user_role;

        // Redirigir según el rol del usuario
        if ($user_role == 'Tutor' || $user_role == 'Estudiante') {
            header("Location: index_tutor.php");
        } elseif ($user_role == 'Administrador' || $user_role == 'Profesor') {
            header("Location: index_encargados.php");
        } else {
            echo "Rol de usuario no válido.";
        }
    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
    }

    mysqli_close($conn);
} else {
    echo "Método de solicitud no válido.";
}
?>
