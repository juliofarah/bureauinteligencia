<?php
    require_once '../util/excel/writer/ExcelWriter.php';

    echo "<center><h1>Testando excel</h1></center>";
    
    $excel = new ExcelWriter("Excel.xls");
    $excel->writeCol("Nome");
    $excel->writeCol("Sobrenome");
    $excel->writeCol("bobagem");
    $excel->writeLine(array("ramonox", "henrique", "gonçalves"));
    $excel->writeLine(array("tundra", "matheus", "bosta"));
    $excel->close();
?>
