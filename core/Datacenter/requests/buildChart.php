<?php
    require_once 'build.php';
    require_once 'core/Datacenter/ChartBuilder.php';
    require_once 'core/Charts/XmlCharts/XmlChart.php';
    require_once 'core/Charts/XmlCharts/MultiSerie/XmlMultiSeries.php';
    require_once 'core/Charts/XmlCharts/MultiSerie/XmlMultiSeriesCombinationColumnLine.php';
    require_once $baseFileUrlDatacenter . '/ControllerBehavior/ChartReport.php';
?>
<?
    $controller->setReport(new ChartReport($factory->getBuilder('chart'),$jsonResponse));
    $subgroup = $font = $type = $variety = $origin = $destiny = $years = null;
    $years = $_GET['ano'];
    if(!isset($_GET[0]) && !isset($_GET[1])){
        $dataParam = fillParams($_GET, $subgroup, $font, $type, $variety, $origin, $destiny);                
        $json = $controller->getReport($dataParam, $years);
        echo $json;
    }else{
        if(isset($_GET[0]) && isset($_GET[1])){
            $group_1 = $group_2 = array();
            $dataParam = fillParams($_GET[0], $subgroup, $font, $type, $variety, $origin, $destiny,$group_1);
            $dataParam2 = fillParams($_GET[1], $subgroup, $font, $type, $variety, $origin, $destiny,$group_2);            
            $json = $controller->getDistinctGroupReport($dataParam,$dataParam2, $years);
            echo $json;
        }
    }
?>
