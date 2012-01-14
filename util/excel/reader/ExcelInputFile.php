<?php
/**
 * Description of ExcelInputFile
 *
 * @author Ramon
 */
class ExcelInputFile {

    /**
     * @var Spreadsheet_Excel_Reader 
     */
    private $spreadSheetReader;

    public function ExcelInputFile(Spreadsheet_Excel_Reader $reader){
        $this->spreadSheetReader = $reader;
    }

    public function getValuesFromAllYears() {
        $years = $this->getYears();
        $values = array();
        foreach($years as $year){                        
            $valuesOfAYear = $this->getValuesFromAYear($year);
            $values[$year] = $valuesOfAYear[$year];
        }        
        return $values;
    }
    
    public function getValuesFromAYear($year) {
        $values = array();
        $columnNumber = $this->getColumnNumberOfAYear($year);
        $lines = $this->lines();        
        foreach($this->allTheLinesButTheFirst() as $line){
            $values[$line[1]] = $line[$columnNumber];
        }        
        return array($year => $values);
    }
    
    private function getColumnNumberOfAYear($year){
        $years = $this->getYears();        
        foreach($years as $col => $y){
            //+2 because the year array has had one element remove 
            //and it starts with index 1
            if($y == $year) return ($col+2);
        }
    }
    
    public function getYears(){        
        $years = $this->firstRow();
        array_shift($years);
        return $years;
    }

    public function getValuesOfColumn($col) {                
        return $this->column($col);
    }

    private function firstRow(){
        return $this->line(1);
    }    

    private function column($col){                
        $column = array();
        $lines = $this->lines();
        for($line = 2; $line <= sizeof($lines); $line++ ){
            array_push($column, $lines[$line][$col]);
        }
        return $column;
    }        
    
    private function line($numberLine){
        $lines = $this->lines();
        return $lines[$numberLine];
    }
    
    private function allTheLinesButTheFirst(){
        $lines = $this->lines();
        array_shift($lines);
        return $lines;
    }
    
    private function lines(){
        return $this->spreadSheetReader->sheets[0]['cells'];
    }
}

?>
