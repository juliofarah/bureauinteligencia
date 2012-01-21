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
    $subgroup = $_GET['subgrupo']; 
    $font = $_GET['fonte'];
    $type = $_GET['tipo'];
    $variety = $_GET['variedade']; 
    $origin = $_GET['origem'];
    $destiny = $_GET['destino']; 
    $years = $_GET['ano'];
?>
<?php
    $json = $controller->getExcelTable($subgroup, $font, $type, $variety, $origin, $destiny, $years);
    echo $json;
?>