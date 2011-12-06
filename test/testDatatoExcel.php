<?php
    require_once '../util/Maps/HashMap.php';
    require_once '../util/excel/writer/MapToExcel.php';
?>

<?php
    
    $values = new HashMap();
    $values->put("rowTitles", array("Nome", "Sobrenome", "Idade"));
    $values->put(0, array("Ramon", "Goncalves", "22"));
    $values->put(1, array("Matheus", "Goncalves", "09"));
    $values->put(2, array("Karen", "Guedes", "23"));
    
    $dataToExcel = new MapToExcel($values);
    
    printLines($dataToExcel);
    printTitles($dataToExcel);
?>

<?
    function printTitles(DataToExcel $dataToExcel){
        $iterator = $dataToExcel->getLineWithTitles()->getIterator();
        printer($iterator);
    }
    
    function printLines(DataToExcel $dataToExcel){
        $iterator = $dataToExcel->getAllLinesValues()->getIterator();
        printer($iterator);
    }
    
    function printer(ArrayIterator $iterator){
        while($iterator->valid()){
            print_r($iterator->current());
            echo "<br /><br />";
            $iterator->next();
        }
    }
?>
