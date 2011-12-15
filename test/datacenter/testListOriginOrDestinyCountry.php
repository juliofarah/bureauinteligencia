<?php
    header('Content-Type: text/html; charset=utf-8');
    require_once '../asserts/Asserts.php';
    require_once '../../core/generics/Param.php';
    require_once '../../core/generics/datacenter/Country.php';
    require_once '../../core/DataBase/Connection.php';
    require_once '../../core/generics/Controller.php';
    require_once '../../core/generics/GenericDao.php';    
?>
<?
    $controller = new Controller(new GenericDao(Connection::connect()));
    assertEquals($controller->origincountries(),jsonExpected());
    echo "<br />";
    assertEquals($controller->destinycountries(),jsonDestinyExpected());
?>
<?
function jsonExpected() {
    $json = '[';
    $json .= '{"id":"1","name":"Brasil"},';
    $json .= '{"id":"2","name":"Col?mbia"},';
    $json .= '{"id":"3","name":"Vietn?"},';
    $json .= '{"id":"4","name":"Guatemala"},';
    $json .= '{"id":"5","name":"Peru"},';
    $json .= '{"id":"6","name":"Qu?nia"},';
    $json .= '{"id":"7","name":"Outros"}';
    $json .= ']';
    return $json;
}
?>
<?
function jsonDestinyExpected() {
    $json = '[';
    $json .= '{"id":"8","name":"EUA"},';
    $json .= '{"id":"9","name":"Fran?a"},';
    $json .= '{"id":"10","name":"Alemanha"},';
    $json .= '{"id":"11","name":"Canad?"},';
    $json .= '{"id":"12","name":"It?lia"},';
    $json .= '{"id":"13","name":"Jap?o"},';
    $json .= '{"id":"14","name":"Outros"}';
    $json .= ']';
    return $json;
}
?>