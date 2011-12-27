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
require_once '../../util/Maps/HashMap.php';

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
    
    /**     
     * @var DatacenterService
     */
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
        $this->repository->expects($this->any())->method('getValuesWithSimpleFilter')->will($this->returnValue($this->listFilteredByOneSubgroup()));
        $subgroup = $variety = $type = $origin = $destiny = $font = array(1);
        //$this->assertEquals(3, $this->repository->getValuesByOneSubgroup($subgroup, $variety, $type, $origin, $destiny, $font)->count());
        $this->assertEquals(3, $this->service->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font)->count());        
    }        
    
    /**
     * @test
     */
    public function serviceGetValuesWithMultipleTypeAndVarietiesOfCoffe(){
        $this->repository->expects($this->any())
                         ->method('getValuesWithMultipleParamsSelected')
                         ->will($this->returnValue($this->listFilteredByOneSubgroupAndDifferentTypesOrVarieties()));    
        $subgroup = $font = $origin = $destiny = array(1);
        $subgroup = 1;
        $variety = $type = array(1,2);
        $this->assertEquals(6, $this->service->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font)->count());
    }   
    
    /**
     * @test
     */
    public function getValuesWhenQueryHasTwoSubgroupsSelectedAndTheReturnMustContainsOneListOfValuesToEachSubgroup(){
        $this->repository->expects($this->at(0))
                         ->method('getValuesWithMultipleParamsSelected')
                         ->with(1, $this->equalTo(array(1,2)), $this->equalTo(array(1,2)), 
                                 $this->equalTo(1), $this->equalTo(1), $this->equalTo(1))
                         ->will($this->returnValue($this->listFilteredByOneSubgroup()));
        $this->repository->expects($this->at(1))
                         ->method('getValuesWithMultipleParamsSelected')
                         ->with(8, $this->equalTo(array(1,2)), $this->equalTo(array(1,2)), 
                                 $this->equalTo(1), $this->equalTo(1), $this->equalTo(1))   
                         ->will($this->returnValue($this->listFilteredByOtherSubgroup()));
        $subgroup = array(1,8);
        $font = $origin = $destiny = 1;
        $variety = $type = array(1,2);
        $values = $this->service->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font);
        $this->assertTrue($values instanceof HashMap);
        $this->assertEquals(1990, $values->get(0)->offsetGet(0)->getYear());
        $this->assertEquals('Brasil', $values->get(1)->offsetGet(0)->getOriginName());
        $this->assertEquals('USA', $values->get(1)->offsetGet(0)->getDestinyName());
        $this->assertEquals('Conilon', $values->get(1)->offsetGet(0)->getVariety());
        $this->assertEquals('Arábica', $values->get(0)->offsetGet(0)->getVariety());
    }
        
    /**************************************************************************/
    /***these methods are used to build the return for the mocked object***/
    private function listFilteredByOneSubgroup(){
        $list = new ArrayIterator();
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
    
    private function listFilteredByOneSubgroupAndDifferentTypesOrVarieties(){
        $list = $this->listFilteredByOneSubgroup();
        $subgroup = new Subgroup('Quantidade Exportada (sc 60kg)',1);
        $font = new Font("OIC", 1);        
        $type = new CoffeType("Solúvel");        
        $variety = new Variety("Conilon");
        $origin = new Country("Brasil");
        $destiny = new Country("USA");
        $data = new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny);
        $list->append($list->append($data));
        $data2 = new Data(1991, $subgroup, $font, $type, $variety, $origin, $destiny);
        $list->append($data2);
        
        return $list;
    }
    
    private function listFilteredByOtherSubgroup(){
        //$valuesSubgroup1 = $this->listFilteredByOneSubgroupAndDifferentTypesOrVarieties();
        
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
}
?>
