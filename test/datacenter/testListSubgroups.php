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
    listSubgroupsFromGroup1($controller);
    listSubgroupsFromGroup2($controller);
    listSubgroupsFromGroup3($controller);
    listSubgroupsFromGroup4($controller);
?>
<?
function listSubgroupsFromGroup1(Controller $controller){
    assertEquals($controller->subgroups(1), jsonExpectedFromGroup1());
}
function listSubgroupsFromGroup2(Controller $controller){
    assertEquals($controller->subgroups(2), jsonExpectedFromGroup2());
}
function listSubgroupsFromGroup3($controller){
    assertEquals($controller->subgroups(3), jsonExpectedFromGroup3());
}
function listSubgroupsFromGroup4($controller){
    assertEquals($controller->subgroups(4), jsonExpectedFromGroup4());
}
?>
<?
function jsonExpectedFromGroup1(){
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
function jsonExpectedFromGroup2(){
    $json = '[';
    $json .= '{"id":"7","name":"Produ??o (sacas de 60kg)"},';
    $json .= '{"id":"8","name":"Estoque"}';
    $json .= ']';
    return $json;    
}
function jsonExpectedFromGroup3(){
    $json = '[';
    $json .= '{"id":"9","name":"Consumo (sacas de 60kg)"},';
    $json .= '{"id":"10","name":"Consumo per capita"}';
    $json .= ']';
    return $json;
}
function jsonExpectedFromGroup4(){
    $json = '[';
    $json .= '{"id":"11","name":"C?mbio"},';
    $json .= '{"id":"12","name":"Pre?o"}';
    $json .= ']';
    return $json;
}
?>