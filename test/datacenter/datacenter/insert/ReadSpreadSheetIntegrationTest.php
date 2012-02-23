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
        
    /**
     * @test
     */
    public function wrongFormatException(){
        $file =__DIR__."/Teste_WrongFormat.xls";
        $this->spreadsheetReader = new Spreadsheet_Excel_Reader($file);              
        $this->setExpectedException('WrongFormatException');
        $this->inputFile = new ExcelInputFile($this->spreadsheetReader);
        $this->fail("Should have been thronw a 'WrongFormatException' cause the Spreadsheet does not have the correct format");
    }
    
    /**
     * @test
     */
    public function correctFormat(){
        $file =__DIR__."/Teste.xls";
        $this->spreadsheetReader = new Spreadsheet_Excel_Reader($file);    
        $this->inputFile = new ExcelInputFile($this->spreadsheetReader);
        $values = $this->inputFile->getYears();
        $this->assertEquals(4, sizeof($values));
        $values = $this->inputFile->getValuesFromACountry("Brasil");
        $this->assertTrue($this->associativeArrayEquals($this->expectedValuesFromACountry(),$values));
    }
    
    private function expectedValuesFromACountry(){
        return array("Brasil" => array("1990" => 222, "1991" => 452, "1992" => 453, "1993" => 234));
    }
    
    private function associativeArrayEquals(array $expected, array $actual){
        $equals = true;
        foreach($expected as $index => $array){
            if(!array_key_exists($index, $actual))
                $equals =  false;
            else{
                foreach($array as $key => $value){                
                    if(!array_key_exists($key, $actual[$index]))
                        $equals = false;
                    else
                        $equals = $equals && ($value == $actual[$index][$key]);
                }
            }
        }
        $this->printIfAreNotEquals($equals, $expected, $actual);
        return $equals;
    }
    
    private function printIfAreNotEquals($equals, array $expected, array $actual){
        if(!$equals){
            print_r($expected);
            echo '\n';
            print_r($actual);
        }
    }
}
?>
