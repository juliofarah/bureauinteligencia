<?php
/**
 * Description of DataObjectTest
 *
 * @author Ramon
 */
class DataObjectTest extends PHPUnit_Framework_TestCase{
    
    /**
     * @test
     */
    public function turnDataToJson(){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type");
        $variety = new Variety("variety",1);
        $origin = new Country("origin");
        $destiny = new Country("destiny");
        
        $data = new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny);
        
        $this->assertEquals($this->jsonExpected(), $data->toJson());
    }
    
    /**
     * @test
     */
    public function datasComparations(){
        $data = $this->newData(1990);
        $data2 = $this->newData(1991);
        $this->assertTrue($data->isOfTheSameCategoryOf($data2));
        $data2 = $this->newData(1991, "Another Variety");
        $this->assertFalse($data->isOfTheSameCategoryOf($data2));
    }
    
    private function newData($year, $varietyName = null){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type");
        if($varietyName == null)
            $variety = new Variety("variety",1);
        else
            $variety = new Variety($varietyName);
        $origin = new Country("origin");
        $destiny = new Country("destiny");
        
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        return $data;
    }
    
    private function jsonExpected(){
        $json = '{';
        $json .= '"year":1990,';
        $json .= '"subgroup":{"name":"subgrupo"},';
        $json .= '"font":{"name":"fonte"},';
        $json .= '"type":{"name":"type"},';
        $json .= '"variety":{"id":1,"name":"variety"},';
        $json .= '"origin":{"name":"origin"},';
        $json .= '"destiny":{"name":"destiny"}';
        $json .= '}';
        
        return $json;
    }
}

?>
