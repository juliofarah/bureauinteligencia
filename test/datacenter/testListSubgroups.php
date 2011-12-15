<?php
    header('Content-Type: text/html; charset=utf-8');
    require_once '../asserts/Asserts.php';
    //require_once '../../core/generics/datacenter/Group.php';
    require_once '../../core/generics/Controller.php';
    require_once '../../core/generics/GenericDao.php';
    require_once '../../core/DataBase/Connection.php';
    require_once '../../core/generics/Param.php';
    require_once '../../core/generics/datacenter/Subgroup.php';
    
    $controller = new Controller(new GenericDao(Connection::connect()));
    assertEquals($controller->subgroups(1), jsonExpected());
?>
<?
function jsonExpected(){
    $json = '[';
    $json .= '{"id":"1","name":"Quantidade Exportada (sc 60kg)"},';
    $json .= '{"id":"2","name":"Quantidade Importada (sc 60kg)"},';
    $json .= '{"id":"3","name":"Quantidade Reexportada (sc 60kg)"},';
    $json .= '{"id":"4","name":"Valor da Exporta??o (US$\/sc 60kg)"},';
    $json .= '{"id":"5","name":"Valor da Importa??o (US$\/sc 60kg)"},';
    $json .= '{"id":"6","name":"Valor da Reexporta??o (US$\/sc 60kg)"}';
    $json .= ']';
    return $json;
}
?>