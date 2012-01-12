<?php
    require_once 'build.php';
    require_once 'core/Datacenter/ChartBuilder.php';
    require_once 'core/Charts/XmlCharts/XmlChart.php';
    require_once 'core/Charts/XmlCharts/MultiSerie/XmlMultiSeries.php';
    require_once 'core/Charts/XmlCharts/MultiSerie/XmlMultiSeriesCombinationColumnLine.php';
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
<?php
    $json = $controller->getChart($subgroup, $font, $type, $variety, $origin, $destiny, $years);
    echo $json;
?>