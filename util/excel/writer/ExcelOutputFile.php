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
     *
     * @var PHPExcel 
     */
    private $writer;
    
    private $spreadPath;
    
    public function ExcelOutputFile(DataToExcel $dataToExcel, $spreadsheetName){
        $this->dataToExcel = $dataToExcel;
        $this->writer = new PHPExcel();
        $name = explode("/", $spreadsheetName);
        $name = str_replace(".xls","", $name[1]);
        $this->writer->getProperties()->setTitle($name);
        $this->spreadPath = $spreadsheetName;
    }
        
    private function putColumtTitlesInSpreadsheet(){
        $titlesIterator = $this->dataToExcel->getLineWithTitles()->getIterator();
        $currentSheet = $this->writer->getActiveSheet();
        //$currentSheet->setTitle("");
        while($titlesIterator->valid()){                       
            $currentSheet->setCellValueByColumnAndRow($titlesIterator->key(),1,$titlesIterator->current());            
            $currentSheet->getStyleByColumnAndRow($titlesIterator->key(),1)->getFont()->setBold(true);
            $currentSheet->getColumnDimensionByColumn($titlesIterator->key())->setAutoSize(true);
            $titlesIterator->next();
        }
    }
   
    private function putLineValuesInSpreadsheet(){
        $lines = $this->dataToExcel->getAllLinesValues()->getIterator();
        $currentSheet = $this->writer->getActiveSheet();
        $row = 2;
        while($lines->valid()){
            foreach($lines->current() as $index => $lineValue){
                $currentSheet->setCellValueByColumnAndRow($index, $row, $lineValue);
            }
            ++$row;
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
        $this->writer->setActiveSheetIndex(0);
        $this->putColumtTitlesInSpreadsheet();
        $this->putLineValuesInSpreadsheet();
        $excelWriter = PHPExcel_IOFactory::createWriter($this->writer, 'Excel5');
        $excelWriter->save($this->spreadPath);        
    }
    
    public function getSpreadSheetFilename(){        
        return $this->spreadPath;
    }
}

?>
