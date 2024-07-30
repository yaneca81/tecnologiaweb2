<?php
require_once __DIR__ . '../../core/Model.php';

class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct('usuario');
    }

    // Aquí puedes agregar métodos específicos para el modelo de usuarios
}
