<?php
    header('Content-Type: text/html; charset=utf-8');
    require_once '../asserts/Asserts.php';
    require_once '../../core/DataBase/Connection.php';
    require_once '../../core/generics/Controller.php';
    require_once '../../core/generics/GenericDao.php';
    require_once '../../core/generics/datacenter/Group.php';

    $controller = new Controller(new GenericDao(Connection::connect()));
    assertEquals($controller->groups(), jsonExpected());
?>

<?

function jsonExpected() {
    $json = '[';
    $json .= '{"id":"1","nome":"Com?rcio Internacional"},';
    $json .= '{"id":"2","nome":"Oferta"},';
    $json .= '{"id":"3","nome":"Demanda"},';
    $json .= '{"id":"4","nome":"Indicadores Econ?micos"}';
    $json .= ']';
    return $json;
}
?>