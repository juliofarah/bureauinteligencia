<?php
    require_once '../util/Maps/HashMap.php';
    require_once '../util/excel/writer/MapToExcel.php';
    require_once '../util/excel/writer/ExcelOutputFile.php';
    require_once '../util/excel/writer/ExcelWriter.php';
?>
<?php

    $values = new HashMap();
    $values->put("rowTitles", array("Nome", "Sobrenome", "Idade"));
    $values->put(0, array("Ramon", "Goncalves", "22"));
    $values->put(1, array("Matheus", "Goncalves", "09"));
    $values->put(2, array("Karen", "Guedes", "22"));
    
    $dataToExcel = new MapToExcel($values);
?>
<?php
    $excelOutputFile = new ExcelOutputFile($dataToExcel, new ExcelWriter("testName.xls"));
    echo $excelOutputFile->getSpreadSheet();
    header("Location: ".$excelOutputFile->getSpreadSheet());
?>