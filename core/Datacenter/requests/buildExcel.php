<?
error_reporting(E_ALL ^ E_NOTICE);
?>
<?php    
    require_once 'requires_build.php';
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
    require_once 'build.php';
?>