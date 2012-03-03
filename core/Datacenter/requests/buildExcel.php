<?
error_reporting(E_ALL ^ E_NOTICE);
?>
<?php
    require_once 'build.php';
    require_once 'core/Datacenter/TableBuilder.php';
    require_once 'core/Datacenter/TableExcelBuilder.php';
    require_once 'util/excel/writer/MapToExcel.php';
    require_once 'util/excel/writer/ExcelWriter.php';
    require_once 'util/excel/writer/ExcelOutputFile.php';    
    require_once 'util/excel/writer/Classes/PHPExcel.php';
    require_once 'util/excel/reader/excel_reader2.php';    
    
    require_once $baseFileUrlDatacenter . '/ControllerBehavior/TableReport.php';
    require_once $baseFileUrlDatacenter . '/ControllerBehavior/TableExcelReport.php';
?>
<?
    $report = new TableExcelReport($factory->getBuilder('spreadsheet'),$jsonResponse);
    $controller->setReport($report);
    
    $years = $_GET['ano'];
    if(isset($_GET[0]) && isset($_GET[1])){
        $g1 = $g2 = null;
        $dataParam = fillParams($_GET[0], $subgroup, $font, $type, $variety, $origin, $destiny, $g1);    
        $dataParam2 = fillParams($_GET[1], $subgroup, $font, $type, $variety, $origin, $destiny, $g2);
        echo $controller->getDistinctGroupsExcelTable($dataParam,$dataParam2,$years);        
        echo $controller->getDistinctGroupReport($dataParam,$dataParam2, $years);
    }else{
        $dataParam = fillParams($_GET, $subgroup, $font, $type, $variety, $origin, $destiny);
        $json = $controller->getReport($dataParam, $years);
        echo $json;
    }
?>