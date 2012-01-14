<?php
require_once '../../util/excel/reader/SpreadsheetValidator.php';
/**
 * Description of SpreadSheetValidatorTest
 *
 * @author Ramon
 */
class SpreadsheetValidatorTest extends PHPUnit_Framework_TestCase{
    
    /**    
     * @var SpreadsheetValidator 
     */
    private $validator;
       
    /**
     * @var ExcelInputFile
     */
    private $inputFile;
    
    protected function setUp(){
       $this->mockExcelInputFile();
       $this->validator = new SpreadsheetValidator($this->inputFile);
    }
    
    private function mockExcelInputFile(){
        $this->inputFile = $this->getMockbuilder('ExcelInputFile')
                          ->disableOriginalConstructor()
                          ->getMock();
        $this->inputFile->expects($this->any())
                  ->method('firstRow')
                  ->will($this->returnValue(array("Paises","Origem",1990,1991,1992)));
       
       $return = array(array("Brasil", 222, 2432, 453), array("Colombia",3242,534,345,234));            
       $this->inputFile->expects($this->any())
                       ->method('allTheLinesButTheFirst')
                       ->will($this->returnValue($return));
       $this->inputFile->expects($this->any())
                       ->method('getYears')
                       ->will($this->returnValue(array(1990,1991,1992)));
    }
    
    /**
     * @test
     */
    public function verifyIfTitleLineIsCorrect(){
        $this->assertFalse($this->validator->firstLinePatternIsCorrect());
    }    
    
    /**
     * @test
     */
    public function verifyLineOfValues(){
        $this->assertFalse($this->validator->linesWithValuesAreCorrect());
    }
    
    /**
     * @test
     */
    public function invalidSpreadsheet(){
        $this->assertFalse($this->validator->spreadsheetHasAValidFormat());
    }
}
?>
