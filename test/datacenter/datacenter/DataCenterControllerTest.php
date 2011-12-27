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
        $subgroup = $font = $type = $variety = $origin = $destiny = 1;
        $this->assertEquals($this->simpleQueryJsonExpected(),
                $this->controller->getValuesWithSimpleParams($subgroup,$font,$type,$variety,$origin,$destiny));
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
    
    private function simpleQueryJsonExpected(){
        return $this->createJsonFromListToAssert($this->listValues()->getIterator());
    }
    
    private function createJsonFromListToAssert(ArrayIterator $list){
        $json = "[";
        while($list->valid()){
            $json .= $list->current()->toJson();
            $json .= ",";
            $list->next();
        }
        $json = substr($json, 0, -1);
        $json .= "]";
        return $json;
    }
}

?>
