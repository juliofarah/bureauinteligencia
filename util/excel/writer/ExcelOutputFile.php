<?php
/**
 * Description of ExcelOutputFile
 *
 * @author Ramon
 */
class ExcelOutputFile {
    
    /**
     * @var DataToExcel 
     */
    private $dataToExcel;
    /**
     * @var ExcelWriter
     */
    private $excelWriter;
    
    public function ExcelOutputFile(DataToExcel $dataToExcel, ExcelWriter $excelWriter){
        $this->dataToExcel = $dataToExcel;
        $this->excelWriter = $excelWriter;
    }
        
    private function putColumtTitlesInSpreadsheet(){
        $titlesIterator = $this->dataToExcel->getLineWithTitles()->getIterator();
        while($titlesIterator->valid()){
            $this->excelWriter->writeCol($titlesIterator->current());
            $titlesIterator->next();
        }
    }
   
    private function putLineValuesInSpreadsheet(){
        $lines = $this->dataToExcel->getAllLinesValues()->getIterator();
        while($lines->valid()){
            $this->excelWriter->writeLine($lines->current());
            $lines->next();
        }
    }
    
    public function getSpreadSheet(){
        $this->putColumtTitlesInSpreadsheet();
        $this->putLineValuesInSpreadsheet();
        $this->excelWriter->close();
        return $this->excelWriter->getFileName();
    }
    
    public function buildSpreadSheet(){
        $this->putColumtTitlesInSpreadsheet();
        $this->putLineValuesInSpreadsheet();
        $this->excelWriter->close();        
    }
    
    public function getSpreadSheetFilename(){
        return $this->excelWriter->getFileName();
    }
}

?>
