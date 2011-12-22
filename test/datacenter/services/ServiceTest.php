<?php

require_once '../../core/Datacenter/DatacenterService.php';
require_once '../../core/Datacenter/DatacenterRepository.php';
require_once '../../core/generics/Param.php';
require_once '../../core/generics/datacenter/Subgroup.php';
require_once '../../core/generics/datacenter/Font.php';
require_once '../../core/generics/datacenter/Variety.php';
require_once '../../core/generics/datacenter/CoffeType.php';
require_once '../../core/generics/datacenter/Country.php';
require_once '../../core/Datacenter/Data.php';

/**
 * Description of ServiceTest
 *
 * @author Ramon
 */
class ServiceTest extends PHPUnit_Framework_TestCase{    
    
    /**
     *
     * @var DatacenterRepository 
     */
    private $repository;
    
    private $service;
    
    public function ServiceTest(){
        $this->repository = $this->getMock("DatacenterRepository");        
        $this->service = new DatacenterService($this->repository);
    }
    /**
     * @test
     */
    public function serviceTestExperiment(){
        $stack = array("test");
        $this->assertEquals(1, count($stack));        
    }        
    
    /**     
     * @test
     */
    public function serviceGetValuesOfExportFromBrazilToUSAOfGreenArabicCoffe(){
        $this->repository->expects($this->any())->method('getValuesFromAGroup')->will($this->returnValue(0));        
        $this->repository->expects($this->any())->method('getValuesByOneSubgroup')->will($this->returnValue($this->listFilteredByOneSubgroup()));
        $subgroup = $variety = $type = $origin = $destiny = $font = array(1);
        //$this->assertEquals(3, $this->repository->getValuesByOneSubgroup($subgroup, $variety, $type, $origin, $destiny, $font)->count());
        $this->assertEquals(3, $this->service->getValuesByOneSubgroup($subgroup, $variety, $type, $origin, $destiny, $font)->count());
    }
    
    private function listFilteredByOneSubgroup(){
        $list = new ArrayObject();
        $subgroup = new Subgroup('Quantidade Exportada (sc 60kg)',1);
        $font = new Font("OIC", 1);
        $type = new CoffeType("Verde");
        $variety = new Variety("Arábica");
        $origin = new Country("Brasil");
        $destiny = new Country("USA");               
        $list->append(new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny));
        $list->append(new Data(1991, $subgroup, $font, $type, $variety, $origin, $destiny));
        $list->append(new Data(1992, $subgroup, $font, $type, $variety, $origin, $destiny));
        
        return $list;
    }
    
}

?>
