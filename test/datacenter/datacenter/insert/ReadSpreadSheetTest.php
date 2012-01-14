<?php
require_once '../../util/excel/reader/excel_reader2.php';
require_once '../../util/excel/reader/ExcelInputFile.php';
/**
 * Description of ReadSpreadSheetTest
 *
 * @author Ramon
 */
class ReadSpreadSheetTest extends PHPUnit_Framework_TestCase{
    
    /**     
     * @var type 
     */
    private $excelInputFile;
    
    /**
     * @var Spreadsheet_Excel_Reader 
     */
    private $spreadsheetReader;
    
    protected function setUp(){
       $file =__DIR__."\Teste.xls";            
       $this->spreadsheetReader = new Spreadsheet_Excel_Reader($file);
       $this->excelInputFile = new ExcelInputFile($this->spreadsheetReader); 
    }
    
    /**
     * @test
     */
    public function readYears(){
        $years = $this->excelInputFile->getYears();
        $this->assertTrue($this->arraysAreEquals($this->expectedYears(),$years));
    }
        
    /**
     * @test
     */
    public function getFullColumn(){
        $values = $this->excelInputFile->getValuesOfColumn(2);
        $this->assertTrue($this->arraysAreEquals($this->expectedValuesOfColumn2(), $values));
    }
        
    /**
     * @test
     */
    public function getValuesFromAYearOfAllCountries(){        
        $actual = $this->excelInputFile->getValuesFromAYear(1990);
        $this->assertTrue($this->associativeArrayEquals($this->associativeArrayExpected(), $actual));
    }
    
    /**
     * @test
     */
    public function getValuesFromAllYearsAndAllCountries(){
        $values = $this->excelInputFile->getValuesFromAllYears();
        $this->assertTrue($this->associativeArrayEquals($this->manyYearsAssociativeArrayExcpected(), $values));
    }
    
    private function expectedValuesOfColumn2(){
        return array(222, 3242);
    }
    
    private function expectedYears(){
        return array(1990, 1991, 1992, 1993);
    }

    private function associativeArrayExpected(){
        return array("1990" => array("Brasil" => "222", "Colombia" => "3242"));
    }
    
    private function manyYearsAssociativeArrayExcpected(){
        return array(
                    "1990" => array("Brasil" => "222", "Colombia" => "3242"),
                    "1991" => array("Brasil" => "2432", "Colombia" => "534"),
                    "1992" => array("Brasil" => "453", "Colombia" => "345"),
                    "1993" => array("Brasil" => "234", "Colombia" => "234")
                );
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
    
    private function arraysAreEquals(array $expected,array $actual){
        $equals = true;        
        if(sizeof($expected) != sizeof($actual))
            $equals = false;
        else
            foreach($actual as $i => $value){            
                $equals = $equals && ($value == $expected[$i]);
            }
        $this->printIfAreNotEquals($equals, $expected, $actual);
        return $equals;
    }
    
    
}

?>
