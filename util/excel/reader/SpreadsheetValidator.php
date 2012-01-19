<?php

/**
 * Description of SpreadsheetValidator
 *
 * @author Ramon
 */
class SpreadsheetValidator {
    
    /**
     * @var ExcelInputFile
     */
    private $excelInputFile;
    
    public function SpreadsheetValidator(ExcelInputFile $excelInputFile){
        $this->excelInputFile = $excelInputFile;
    }
    
    public function spreadsheetHasAValidFormat() {
        return ($this->firstLinePatternIsCorrect() && $this->linesWithValuesAreCorrect());
    }
        
    public function firstLinePatternIsCorrect() {        
        $firstLine = $this->excelInputFile->firstRow();
        if(utf8_encode($firstLine[1]) != 'Países') return false;        
        return $this->lineNumberPatterns($firstLine);
    }

    private function lineNumberPatterns(array $line){          
        for($col = 2; $col <= sizeof($line); $col++){            
            if(is_string($line[$col])) return false;
        }
        return true;
    }
    
    public function linesWithValuesAreCorrect() {
        $allLines = $this->excelInputFile->allTheLinesButTheFirst();
        foreach($allLines as $line){            
            if(!is_string($line[1])) return false;
            if(!$this->lineNumberPatterns($line)) return false;            
            array_shift($line);
            if(sizeof($line) > sizeof($this->excelInputFile->getYears())) return false;            
        }
        return true;
    }
}

?>
