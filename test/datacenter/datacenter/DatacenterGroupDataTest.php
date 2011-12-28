<?php
require_once '../../core/Datacenter/DataGrouper.php';
/**
 * Description of DatacenterGroupDataTest
 *
 * @author Ramon
 */
class DatacenterGroupDataTest extends PHPUnit_Framework_TestCase{
    
    /**
     * @test
     */
    public function groupValuesIfAllParamsAreEqualsAndYearDoNot(){
        $grouper = new DataGrouper();
        $this->assertTrue($grouper->groupDataValues($this->listOfValues()) instanceof HashMap);
        $this->assertTrue($grouper->groupDataValues($this->listOfValues())->get(0) instanceof ArrayObject);
        $this->assertEquals(3, $grouper->groupDataValues($this->listOfValues())->get(0)->count());
    }
    
    private function listOfValues(){
        $list = new ArrayObject();
        $list->append($this->newData(1990));
        $list->append($this->newData(1991));
        $list->append($this->newData(1992));
        $list->append($this->newAnotherData(1990));
        $list->append($this->newAnotherData(1991));
        $list->append($this->newAnotherData(1992));
        return $list;
    }
    
    private function newData($year){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type");
        $variety = new Variety("variety",1);
        $origin = new Country("origin");
        $destiny = new Country("destiny");
        
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        
        return $data;
    }
    
    private function newAnotherData($year){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type2",2);
        $variety = new Variety("variety2",2);
        $origin = new Country("origin2",2);
        $destiny = new Country("destiny2",2);
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        return $data;
    }
}

?>
