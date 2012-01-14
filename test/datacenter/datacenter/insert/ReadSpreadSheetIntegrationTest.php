<?php
require_once '../../core/Exceptions/WrongFormatException.php';
/**
 * Description of ReadSpreadSheetIntegrationTest
 *
 * @author Ramon
 */
class ReadSpreadSheetIntegrationTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var Spreadsheet_Excel_Reader 
     */
    private $spreadsheetReader;
    
    /**
     * @var ExcelInputFile 
     */
    private $inputFile;
    
    protected function setUp(){
        $file =__DIR__."\Teste_WrongFormat.xls";        
        $this->spreadsheetReader = new Spreadsheet_Excel_Reader($file);       
    }
    
    /**
     * @test
     */
    public function wrongFormatException(){
        $this->setExpectedException('WrongFormatException');
        $this->inputFile = new ExcelInputFile($this->spreadsheetReader);
        $this->fail("Should have been thronw a 'WrongFormatException' cause the Spreadsheet does not have the correct format");
    }
}

?>
