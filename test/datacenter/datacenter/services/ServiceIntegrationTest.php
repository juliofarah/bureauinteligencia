<?php

require_once '../../core/Datacenter/Statistic/Statistic.php';
/**
 * Description of ServiceIntegrationTest
 *
 * @author raigons
 */
class ServiceIntegrationTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var DatacenterRepository 
     */
    private $repository;
    
    /**     
     * @var DatacenterService
     */
    private $service;

    /**
     * @var Statistic
     */
    private $statistic;
    
    protected function setUp(){
        $this->repository = $this->getMock('DatacenterRepository');
        $this->statistic = new Statistic();
        $this->service = new DatacenterService($this->repository, null, $this->statistic);
        $this->repository->expects($this->any())
                         ->method('getValuesWithMultipleParamsSelected')
                         ->with(1, $this->equalTo(array(1,2)), $this->equalTo(array(1,2)), 
                                 $this->equalTo(1), $this->equalTo(1), $this->equalTo(1))
                         ->will($this->returnValue($this->listFilteredByOneSubgroup(true)));        
    }
            
    /**
     * @test 
     */
    public function getStandardDeviation(){
        $subgroup = 1;
        $font = $origin = $destiny = 1;
        $variety = $type = array(1,2);
        $values = $this->service->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font);
        $this->assertEquals(200, $this->service->getAverage($values));
        $values->rewind();
        $this->assertEquals(100, $this->service->getSampleStandardDeviation($values));
        $values->rewind();
        $this->assertEquals(81.65, $this->service->getPopulationalStandardDeviation($values));        
    }
    
    /**
     * @test
     */
    public function getVariance(){
        $subgroup = 1;
        $font = $origin = $destiny = 1;
        $variety = $type = array(1,2);
        $values = $this->service->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font);
        $this->assertEquals(10000, $this->service->getSampleVariance($values));
        $values->rewind();
        $this->assertEquals(6666.67, $this->service->getPopulationalVariance($values));
    }

    /***these methods are used to build the return for the mocked object***/
    private function listFilteredByOneSubgroup($values = false){
        $list = new ArrayIterator();
        $subgroup = new Subgroup('Quantidade Exportada (sc 60kg)',1);
        $font = new Font("OIC", 1);
        $type = new CoffeType("Verde");
        $variety = new Variety("Arábica");
        $origin = new Country("Brasil");
        $destiny = new Country("USA");
        if(!$values){
            $list->append(new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny));
            $list->append(new Data(1991, $subgroup, $font, $type, $variety, $origin, $destiny));
            $list->append(new Data(1992, $subgroup, $font, $type, $variety, $origin, $destiny));            
        }else{
            $data = new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny);
            $data->setValue(200);
            $list->append($data);
            $data = new Data(1991, $subgroup, $font, $type, $variety, $origin, $destiny);
            $data->setValue(100);
            $list->append($data);
            $data = new Data(1992, $subgroup, $font, $type, $variety, $origin, $destiny);
            $data->setValue(300);
            $list->append($data);
        }
        return $list;
    }    
}

?>
