<?php
    require_once 'build.php';
    require_once '../TableBuilder.php';
    require_once '../TableJsonBuilder.php';
?>
<?
    $subgroup = $_GET['subgrupo']; 
    $font = $_GET['fonte'];
    $type = $_GET['tipo'];
    $variety = $_GET['variedade']; 
    $origin = $_GET['origem'];
    $destiny = $_GET['destino']; 
    $years = $_GET['ano'];
?>
<?     
    $json = $controller->getTable($subgroup, $font, $type, $variety, $origin, $destiny, $years);
    echo $json;
?>