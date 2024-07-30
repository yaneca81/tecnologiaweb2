<?php
require_once 'core/Model.php';

$id = $_GET['id'];
$entity = $_GET['entity'];
$route = $_GET['route'];

$model = new Model($entity);

if ($entity == 'propiedad') {
    $model->executeQuery("DELETE FROM propiedad_caracteristica WHERE id_propiedad = $id");
    $model->executeQuery("DELETE FROM imagen WHERE id_propiedad = $id");
    $model->delete($id);
    header('Location: ' . BASE_URL . '/admin/propiedades');
} else {
    $model->delete($id);
    header('Location: ' . BASE_URL . '/admin/' . $route);
}
