<?php
    header('Content-Type: text/html; charset=utf-8');
    require_once '../asserts/Asserts.php';
    require_once '../../core/generics/Param.php';
    require_once '../../core/generics/datacenter/Variety.php';
    
    require_once '../../core/DataBase/Connection.php';
    require_once '../../core/generics/Controller.php';
    require_once '../../core/generics/GenericDao.php';        
?>
<?php
    $controller = new Controller(new GenericDao(Connection::connect()));
    assertEquals($controller->varieties(), jsonExpected());
?>

<?
function jsonExpected() {
    $json = '[';
    $json .= '{"id":"1","name":"Ar?bica"},';
    $json .= '{"id":"2","name":"Conilon"}';
    $json .= ']';
    return $json;
}
?>
