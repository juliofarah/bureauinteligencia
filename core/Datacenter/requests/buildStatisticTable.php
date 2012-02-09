<?php
    require_once 'build.php';
    require_once 'core/Datacenter/TableBuilder.php';
    require_once 'core/Datacenter/TableJsonBuilder.php';
    require_once 'core/Datacenter/TableStatisticsJsonBuilder.php';
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
    $json = $controller->getStatisticTable($subgroup, $font, $type, $variety, $origin, $destiny,$years);
    echo $json;
?>