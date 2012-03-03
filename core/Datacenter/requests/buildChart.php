<?php    
    require_once 'requires_build.php';
    require_once 'core/Datacenter/ChartBuilder.php';
    require_once 'core/Charts/XmlCharts/XmlChart.php';
    require_once 'core/Charts/XmlCharts/MultiSerie/XmlMultiSeries.php';
    require_once 'core/Charts/XmlCharts/MultiSerie/XmlMultiSeriesCombinationColumnLine.php';
    require_once $baseFileUrlDatacenter . '/ControllerBehavior/ChartReport.php';
?>
<?
    $report = new ChartReport($factory->getBuilder('chart'),$jsonResponse);
    require_once 'build.php';
?>
