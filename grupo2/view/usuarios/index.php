<?php
require_once  '../../model/UserModel.php';
$userModel = new UserModel();

$users = $userModel->findAll();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Lista de Usuarios</title>
</head>

<body>
    <h1>Lista de Usuarios</h1>
    <ul>
        <?php foreach ($users as $user) : ?>
            <li><?= htmlspecialchars($user['correo']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>