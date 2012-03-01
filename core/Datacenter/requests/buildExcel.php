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
?>
<?
    $years = $_GET['ano'];
?>
<?php
     $dataParam = fillParams($_GET, $subgroup, $font, $type, $variety, $origin, $destiny);
    $json = $controller->getExcelTable($dataParam, $years);
    echo $json;
?>