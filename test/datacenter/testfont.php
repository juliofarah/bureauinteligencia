<?php
    header('Content-Type: text/html; charset=utf-8');
    require_once '../../util/Maps/HashMap.php';
    require_once '../asserts/Asserts.php';
    require_once '../../core/generics/Param.php';
    require_once '../../core/generics/datacenter/Font.php';
    require_once '../../core/generics/datacenter/Group.php';
    require_once '../../core/DataBase/Connection.php';
    require_once '../../core/generics/Controller.php';
    require_once '../../core/generics/GenericDao.php';    
?>
<?
    $controller = new Controller(new GenericDao(Connection::connect()));
    assertEquals($controller->fonts(1),jsonExpected());
    assertEquals($controller->fonts(4), jsonExpectedForGroup4());
?>
<?
function jsonExpected() {
    $json = '[';
    $json .= '{"id":"1","name":"OIC"},';
    $json .= '{"id":"2","name":"USDA"},';
    $json .= '{"id":"3","name":"Contrade"},';
    $json .= '{"id":"4","name":"AliceWeb"}';
    $json .= ']';
    return $json;
}
function jsonExpectedForGroup4(){
    $json = '[';
    $json .= '{"id":"9","name":"Bacen"},';
    $json .= '{"id":"10","name":"Bloonberg"}';
    $json .= ']';
    return $json;    
}
?>
