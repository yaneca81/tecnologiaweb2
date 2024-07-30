<?php
function debug($values)
{
    echo "<pre>";
    var_dump($values);
    echo "</pre>";
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'config/web.php';

$request = $_SERVER['REQUEST_URI'];
$request = str_replace(BASE_PATH, '', $request);
$queryParams = explode('?', $request);

$request = $queryParams[0];
$request = ltrim($request, '/');

$queryString = isset($queryParams[1]) ? $queryParams[1] : '';


//TODO: Add more routes

switch ($request) {
    case '':
    case 'index.php':
        require 'view/client/index.php';
        break;
    case 'properties.php':
        require 'view/client/properties.php';
        break;
    case 'property.php':
        $_SERVER['QUERY_STRING'] = $queryString;
        require 'view/client/property.php';
        break;
    case 'services.php':
        require 'view/client/services.php';
        break;
    case 'about.php':
        require 'view/client/about.php';
        break;
    case 'contact.php':
        require 'view/client/contact.php';
        break;
    case 'admin':
    case 'admin/index.php':
        require 'view/admin/index.php';
        break;
    case 'auth/registro.php':
        require 'view/auth/registro.php';
        break;
    case 'auth/login.php':
        require 'view/auth/login.php';
        break;
    case 'auth/logout.php':
        require 'view/auth/logout.php';
        break;
    case 'admin/propiedades':
    case 'admin/propiedades.php':
        require 'view/admin/properties/index.php';
        break;
    case 'admin/propiedades/form':
    case 'admin/propiedades/form.php':
        require 'view/admin/properties/form.php';
        break;
    case 'admin/consultas':
    case 'admin/consultas.php':
        require 'view/admin/consultas/index.php';
        break;
    case 'admin/usuarios':
    case 'admin/usuarios.php':
        require 'view/admin/usuarios/index.php';
        break;
    case 'admin/usuarios/form':
    case 'admin/usuarios/form.php':
        require 'view/admin/usuarios/form.php';
        break;
    case 'admin/tipos/lista':
    case 'admin/tipos/lista.php':
        require 'view/admin/tipos/lista.php';
        break;
    case 'admin/tipos/crear':
    case 'admin/tipos/crear.php':
        require 'view/admin/tipos/crear.php';
        break;

    case 'admin/caracteristicas':
    case 'admin/caracteristicas.php':
        require 'view/admin/characteristics/index.php';
        break;
    case 'admin/caracteristicas/form':
    case 'admin/caracteristicas/form.php':
        require 'view/admin/characteristics/form.php';
        break;

    case 'admin/ubicaciones':
    case 'admin/ubicaciones.php':
        require 'view/admin/location/index.php';
        break;
    case 'admin/ubicaciones/form':
    case 'admin/ubicaciones/form.php':
        require 'view/admin/location/form.php';
        break;

    case 'admin/tipos':
    case 'admin/tipos.php':
        require 'view/admin/tipos/lista.php';
        break;
    case 'admin/tipos/crear':
    case 'admin/tipos/crear.php':
        require 'view/admin/tipos/crear.php';
        break;
    case 'admin/delete':
        require 'view/admin/delete.php';
        break;
    default:
        http_response_code(404);
        require 'view/404.php';
        break;
}
