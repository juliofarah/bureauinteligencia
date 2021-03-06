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
require_once '../../core/Datacenter/CountryMap.php';

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
     * @return ExcelInputFile 
     */
    private function mockExcelInputFile(){
        $excelInputFile = $this->getMockBuilder('ExcelInputFile')->disableOriginalConstructor()->getMock();
        $valuesByCountry = array("Brasil" => array("1990" => 222, "1991" => 2432, "1992" => 453, "1993" => 234));
        $excelInputFile->expects($this->any())
                       ->method('getValuesFromACountry')
                       ->will($this->returnValue($valuesByCountry));
        $excelInputFile->expects($this->any())
                       ->method('getValuesOfColumn')
                       ->will($this->returnValue(array("Brasil")));
        $excelInputFile->expects($this->any())
                       ->method('getYears')
                       ->will($this->returnValue(array("1990","1991","1992","1993")));        
        //$excelInputFile->expects($this->any())
          //             ->method('getValuesFromAllCountries')
            //           ->will($this->returnValue());
        return $excelInputFile;
    }
    
    private function buildData($year, $values){
        $data = new Data($year, 1, 1, 1, 1, 1, 1);
        $data->setValue($values);
        return $data;
    }
    /**
     * @test
     */
    public function serviceInsertionTest(){
        $excelInputFile = $this->mockExcelInputFile();
        $data = new ArrayObject();
        $this->repository->expects($this->any())
                         ->method("save")
                         //->with($data)
                         ->will($this->returnValue(true));
        $list = new ArrayObject();
        $list->append($this->buildData(1990, 222));
        $list->append($this->buildData(1991, 2432));
        $list->append($this->buildData(1992, 453));
        //$list->append($this->buildData(1993, 234));
        $this->repository->expects($this->any())
                         ->method('getValuesWithSimpleFilter')
                         ->will($this->returnValue($list->getIterator()));
        $this->service = new DatacenterService($this->repository, new CountryMap());
        $subgroup = $destiny = $type = $variety = $font = 1;
        $this->assertTrue($this->service->insertValues($excelInputFile, $subgroup, $destiny, $type, $variety, $font));
    }
    
    /**     
     * @test
     */
    public function serviceGetValuesOfExportFromBrazilToUSAOfGreenArabicCoffe(){
        $this->repository->expects($this->any())->method('getValuesFromAGroup')->will($this->returnValue(0));
        $this->repository->expects($this->any())->method('getValuesWithSimpleFilter')->will($this->returnValue($this->listFilteredByOneSubgroup()));
        $subgroup = $variety = $type = $origin = $destiny = $font = array(1);
        //$this->assertEquals(3, $this->repository->getValuesByOneSubgroup($subgroup, $variety, $type, $origin, $destiny, $font)->count());
        $dataParam = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
        $this->assertEquals(3, $this->service->getValuesWithSimpleFilter($dataParam, array("ano1","ano2"))->count());        
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
        $dataParam = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
        $this->assertEquals(6, $this->service->getValuesFilteringWithMultipleParams($dataParam, array(1,2))->count());
    }   
    
    /**
     *  @test
     */
    public function getValuesWhenQueryHasTwoSubgroupsSelectedAndTheReturnMustContainsOneListOfValuesToEachSubgroup(){        
       $subgroup = $origin = $destiny = $font = 1; $variety = $type = array(1,2); 
       $dataParams = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
       $this->repository->expects($this->at(0))
                    ->method('getValuesWithMultipleParamsSelected')
                    ->with($this->equalTo($dataParams),$this->equalTo(array(1,2)))
                    ->will($this->returnValue($this->listFilteredByOneSubgroup()));
       $subgroup = 8; $origin = $destiny = $font = 1; $variety = $type = array(1,2); 
       $dataParams2 = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
       $this->repository->expects($this->at(1))
                    ->method('getValuesWithMultipleParamsSelected')
                    ->with($this->equalTo($dataParams2),$this->equalTo(array(1,2)))
                    ->will($this->returnValue($this->listFilteredByOtherSubgroup()));
        
        $subgroup = array(1,8);
        $font = $origin = $destiny = 1;
        $variety = $type = array(1,2);
        $dataParam = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
        $values = $this->service->getValuesFilteringWithMultipleParams($dataParam, array(1,2));
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
