<?php
require_once '../../util/excel/writer/MapToExcel.php';
require_once '../../core/Datacenter/TableBuilder.php';
require_once '../../core/Datacenter/TableExcelBuilder.php';
require_once '../../util/excel/writer/Classes/PHPExcel.php';
//require_once '../../util/excel/writer/ExcelWriter.php';
require_once '../../util/excel/writer/ExcelOutputFile.php';
/**
 * Description of DatacenterExcelBuilderTest
 *
 * @author Ramon
 */
class DatacenterExcelBuilderTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var TableExcelBuilder 
     */
    private $excelBuilder;
    
    /**
     *
     * @var DataToExcel
     */
    private $dataToExcel;
    
    protected function setUp(){
       $this->dataToExcel = new MapToExcel();
       $this->excelBuilder = new TableExcelBuilder($this->dataToExcel); 
    }
    
    /**
     * @test
     */
    public function testAddTitles(){
        $map = $this->groupedList();
        $this->excelBuilder->build($map, array(1989,1992));
        $titles = $this->excelBuilder->getTitles();        
        $this->assertTrue($this->arraysAreEquals($this->expectedTitles(), 
                $titles->getArrayCopy()));
    }
    
    /**
     * @test
     */
    public function testAddValues(){
        $map = $this->groupedList();        
        $this->assertEquals("spreadsheet/Planilha.xls", $this->excelBuilder->build($map, array(1989,1992)));
        $values = $this->excelBuilder->getValues();     
        $this->assertEquals(3, $values->count());
        $this->assertTrue($this->arraysAreEquals($this->expectedValues(), $values->getArrayCopy()));                
    }
    
    private function expectedTitles(){
        return array("Variedade","Tipo","Origem","Destino","1989","1990","1991","1992");
    }
       
    
    private function expectedValues(){
        return array(
                    array("variety","type","origin","destiny","150","220","285","-"),
                    array("variety2","type2","origin2","destiny2","188","302","254","195"),
                    array("variety3","type3","origin3","destiny2","-","101","148","157"));
    }
    
    private function arraysAreEquals(array $expected,array $actual){
        $equals = true;        
        if(sizeof($expected) != sizeof($actual))
            return false;
        foreach($actual as $i => $value){            
            $equals = $equals && ($value == $expected[$i]);
        }
        return $equals;
    }
    
    protected function newData($year, $value){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type");
        $variety = new Variety("variety",1);
        $origin = new Country("origin");
        $destiny = new Country("destiny");
        
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data->setValue($value);
        return $data;
    }
    
    protected function newAnotherData($year, $value){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type2",2);
        $variety = new Variety("variety2",2);
        $origin = new Country("origin2",2);
        $destiny = new Country("destiny2",2);
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data->setValue($value);
        return $data;
    }
    
    protected function newOtherData($year, $value){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte1");
        $type = new CoffeType("type3",2);
        $variety = new Variety("variety3",2);
        $origin = new Country("origin3",2);
        $destiny = new Country("destiny2",2);
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data->setValue($value);
        return $data;
    }
    
    protected function groupedList(){
        //map <int, ArrayList<Data>>
        $map = new HashMap();
        $arrayList = new ArrayObject();
        $arrayList->append($this->newData(1989,150));
        $arrayList->append($this->newData(1990,220));
        $arrayList->append($this->newData(1991,285));
        $map->put(0, $arrayList);        
        $arrayList = new ArrayObject();
        $arrayList->append($this->newAnotherData(1989,188));
        $arrayList->append($this->newAnotherData(1990,302));
        $arrayList->append($this->newAnotherData(1991,254));
        $arrayList->append($this->newAnotherData(1992,195));
        $map->put(1, $arrayList);
        $arrayList = new ArrayObject();
        $arrayList->append($this->newOtherData(1990, 101));
        $arrayList->append($this->newOtherData(1991, 148));
        $arrayList->append($this->newOtherData(1992, 157));
        $map->put(2, $arrayList);
        return $map;
    }    
}

?>
