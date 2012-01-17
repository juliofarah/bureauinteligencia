<?php
/**
 * Description of IntegrationServiceInsertData
 *
 * @author Ramon
 */
class IntegrationServiceInsertDataTest extends PHPUnit_Framework_TestCase{
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
     * @var DatacenterDao 
     */
    private $dao;
    
    protected function setUp(){
        $file = __DIR__."\Teste_2.xls";
        $this->spreadsheetReader = new Spreadsheet_Excel_Reader($file);
        $this->inputFile = new ExcelInputFile($this->spreadsheetReader);
        $this->dao = new DatacenterDao(Connection::connectToTest());        
    }
    
    /**
     * @test
     */
    public function correctlySaveValues(){
        $countryMap = new CountryMap();
        $service = new DatacenterService($this->dao, $countryMap);
        $this->emptyDatabase();
        $service->insertValues($this->inputFile, 1, 1, 1, 1, 1);
        $values = $service->getValuesWithSimpleFilter(1, 1, 1, 1, 1, 1);
        $this->assertEquals(2, $values->count());
    }
    
    private function emptyDatabase(){
        Connection::connectToTest()->prepare("TRUNCATE TABLE data")->execute();
    }
    /**
     * @test
     */
    public function doNotInsertWhenValuesAreadyExist(){
        $countryMap = new CountryMap();
        $service = new DatacenterService($this->dao, $countryMap);
        $service->insertValues($this->inputFile, 1, 1, 1, 1, 1);
        $this->assertEquals(2, $service->getValuesWithSimpleFilter(1, 1, 1, 1, 1, 1)->count());
        $this->emptyDatabase();
        
        $file = __DIR__."\Teste.xls";
        $this->spreadsheetReader = new Spreadsheet_Excel_Reader($file);
        $this->inputFile->setNewSpreadsheet($this->spreadsheetReader);
        $service->insertValues($this->inputFile, 1, 1, 1, 1, 1);
        $this->assertEquals(4, $service->getValuesWithSimpleFilter(1, 1, 1, 1, 1, 1)->count());
    }
}

?>
