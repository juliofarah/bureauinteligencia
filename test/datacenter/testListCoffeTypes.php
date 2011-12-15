<?php
    header('Content-Type: text/html; charset=utf-8');
    require_once '../asserts/Asserts.php';
    require_once '../../core/generics/Param.php';
    require_once '../../core/generics/datacenter/CoffeType.php';
    require_once '../../core/DataBase/Connection.php';
    require_once '../../core/generics/Controller.php';
    require_once '../../core/generics/GenericDao.php';        
?>
<?
    $controller = new Controller(new GenericDao(Connection::connect()));
    assertEquals($controller->coffeTypes(), jsonExpected());
?>
<?
function jsonExpected() {
    $json = '[';
    $json .= '{"id":"1","name":"Verde"},';
    $json .= '{"id":"2","name":"T&M"},';
    $json .= '{"id":"3","name":"Sol?vel"}';
    $json .= ']';
    return $json;
}
?>