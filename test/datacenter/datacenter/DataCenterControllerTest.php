<?php
require_once '../../core/Datacenter/DatacenterController.php';
/**
 * Description of DataCenterControllerTest
 *
 * @author Ramon
 */
class DataCenterControllerTest extends PHPUnit_Framework_TestCase{
    
    /**     
     * @var DatacenterController 
     */
    private $controller;
    
    /**     
     * @var DatacenterService 
     */
    private $dataCenterService;
    
    /**
     * @var Statistic 
     */
    private $statistic;
    
    /**
     * @var JsonResponse 
     */
    private $jsonResponse;
    
    private function mockObjects(){
        $this->dataCenterService = $this->getMockBuilder('DatacenterService')
                                        ->disableOriginalConstructor()
                                        ->getMock();
        $this->statistic = $this->getMock("Statistic");
        $this->jsonResponse = $this->getMock("JsonResponse");
    }
    
    /**
     * @test
     */  
    public function getValuesWithSimpleParams(){        
        $this->mockObjects();
        $this->dataCenterService->expects($this->any())
                                ->method('getValuesWithSimpleFilter')
                                ->will($this->returnValue($this->listValues()->getIterator()));
        $this->controller = new DatacenterController($this->dataCenterService, $this->statistic, $this->jsonResponse);
        $this->controller->getValuesAsJson();
        $subgroup = $font = $type = $variety = $origin = $destiny = 1;
        $this->assertEquals($this->simpleQueryJsonExpected(),
                $this->controller->getValuesWithSimpleParams($subgroup,$font,$type,$variety,$origin,$destiny));
    }
    
    /**
     * @test
     */
    public function getValuesWithMultipleParams(){
        $this->mockObjects();
        $this->dataCenterService->expects($this->any())
                                ->method('getValuesFilteringWithMultipleParams')
                                ->will($this->returnValue($this->listWithDifferentFilters()->getIterator()));
        $this->controller = new DatacenterController($this->dataCenterService, $this->statistic, $this->jsonResponse);
        $this->controller->getValuesAsJson();
        $subgroup = $font = $type = $origin = 1;
        $variety = $destiny = array(1,2);
        $this->assertEquals($this->multipleParamsJsonExpected(),
                            $this->controller->getValuesWithMultipleParams($subgroup, $font, $type, $variety, $origin, $destiny));
    }
    
    /**
     * @test
     */
    public function getValuewWithMoreThanOneSubgroupSelected(){
        $this->mockObjects();
        $map = new HashMap();
        $map->put(0, $this->listValues());
        $map->put(1, $this->listFilteredByOtherSubgroup());
        $this->dataCenterService->expects($this->any())
                                ->method('getValuesFilteringWithMultipleParams')
                                ->will($this->returnValue($map));
        $this->controller = new DatacenterController($this->dataCenterService, $this->statistic, $this->jsonResponse);
        $this->controller->getValuesAsJson();
        $subgroup = array(1,8);
        $type = $font = $origin = $destiny = 1;        
        $variety = array(1,2);        
        $this->assertEquals($this->twoSubgroupsJsonExepcted(), 
                    $this->controller->getValuesFilteringByTwoSubgroups($subgroup, $font, $type, $variety, $origin, $destiny));        
    }
    
    /**
     * @test
     */
    public function makeControllerRedirectToCorrectMethodAccordingToParams(){
        $this->mockObjects();
        $this->dataCenterService->expects($this->any())
                                ->method('getValuesWithSimpleFilter')
                                ->will($this->returnValue($this->listValues()->getIterator()));
        $this->dataCenterService->expects($this->any())
                                ->method('getValuesFilteringWithMultipleParams')
                                ->will($this->returnValue($this->listWithDifferentFilters()->getIterator()));
        $this->controller = new DatacenterController($this->dataCenterService, $this->statistic, $this->jsonResponse);    
        $this->controller->getValuesAsJson();
        $subgroup = $font = $type = $variety = $origin = $destiny = 1;
        $this->assertEquals($this->simpleQueryJsonExpected(), $this->controller->getValues($subgroup, $font, $type, $variety, $origin, $destiny));        
        $variety = array(1,2,3);
        $type = array(1,2);
        $destiny = array(6,7,8,9);
        $this->assertEquals($this->multipleParamsJsonExpected(), 
                $this->controller->getValues($subgroup, $font, $type, $variety, $origin, $destiny));
    }
    
    /**
     * @test
     */
    public function makeControllerRedirectToTwoSubgroupsMethod(){
        $this->mockObjects();
        $this->controller = new DatacenterController($this->dataCenterService, $this->statistic, $this->jsonResponse);
        $this->controller->getValuesAsJson();
        $map = new HashMap();
        $map->put(0, $this->listValues());
        $map->put(1, $this->listFilteredByOtherSubgroup());
        $this->dataCenterService->expects($this->any())
                                ->method('getValuesFilteringWithMultipleParams')
                                ->will($this->returnValue($map));
        $subgroup = $font = $type = $variety = $origin = $destiny = 1;
        $variety = array(1,2,3);
        $type = array(1,2);
        $destiny = array(6,7,8,9);
        $subgroup = array(1,2);
        $this->assertEquals($this->twoSubgroupsJsonExepcted(), 
                $this->controller->getValues($subgroup, $font, $type, $variety, $origin, $destiny));
    }
        
    private function listValues(){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type");
        $variety = new Variety("variety",1);
        $origin = new Country("origin");
        $destiny = new Country("destiny");
        
        $data = new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data2 = new Data(1991, $subgroup, $font, $type, $variety, $origin, $destiny);
        $list = new ArrayObject();
        $list->append($data);
        $list->append($data2);
        return $list;
    }
    
    private function listWithDifferentFilters(){
        $list = $this->listValues();
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type");
        $variety = new Variety("variety2",2);
        $origin = new Country("origin");
        $destiny = new Country("destiny");
        
        $data = new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny);
        $list->append($data);
        $destiny = new Country("destiny2");
        $list->append(new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny));
        return $list;
    }
    
    private function listFilteredByOtherSubgroup(){            
        $valuesSubgroup2 = new ArrayObject();
        $subgroup = new Subgroup('Estoque',8);
        $font = new Font("USDA");
        $variety = new Variety("Conilon");
        $type = new CoffeType("Verde");
        $origin = new Country("Brasil");
        $destiny = new Country("USA");
        $data = new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny);
        $valuesSubgroup2->append($data);
        $data = new Data(1991, $subgroup, $font, $type, $variety, $origin, $destiny);
        $valuesSubgroup2->append($data);
        
        return $valuesSubgroup2;
    }
    
    private function simpleQueryJsonExpected(){
        return $this->createJsonFromListToAssert($this->listValues()->getIterator());
    }
    
    private function multipleParamsJsonExpected(){
        return $this->createJsonFromListToAssert($this->listWithDifferentFilters()->getIterator());
    }
    
    private function twoSubgroupsJsonExepcted(){
        $json = '{';
        $json .= '"subgroup_1":'.$this->createJsonFromListToAssert($this->listValues()->getIterator()).',';
        $json .= '"subgroup_2":'.$this->createJsonFromListToAssert($this->listFilteredByOtherSubgroup()->getIterator());
        $json .= '}';
        
        return $json;
    }
    
    private function createJsonFromListToAssert(ArrayIterator $list){
        $json = '[';
        while($list->valid()){
            $json .= $list->current()->toJson();
            $json .= ",";
            $list->next();
        }
        $json = substr($json, 0, -1);
        $json .= ']';
        return $json;
    }
}

?>
