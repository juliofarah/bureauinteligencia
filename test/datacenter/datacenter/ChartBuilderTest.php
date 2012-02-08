<?php
require_once '../../core/Datacenter/Builder.php';
require_once '../../core/Charts/XmlCharts/XmlChart.php';
require_once '../../core/Charts/XmlCharts/MultiSerie/XmlMultiSeries.php';
require_once '../../core/Charts/XmlCharts/MultiSerie/XmlMultiSeriesCombinationColumnLine.php';
require_once '../../core/Datacenter/ChartBuilder.php';
/**
 * Description of ChartBuilderTest
 *
 * @author Ramon
 */
class ChartBuilderTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var Builder 
     */
    private $chartBuilder;
    
    /**     
     * @var XmlMultiSeriesCombinationColumnLine 
     */
    private $dataXml;
    
    protected function setUp(){
        $this->dataXml = new XmlMultiSeriesCombinationColumnLine();
        $this->chartBuilder = new ChartBuilder($this->dataXml);
    }
    
    /**
     * @test
     */
    public function getSimpleChart(){
        $mapWithGroupedValues = $this->groupedList();
        $years = array(1989,1991);
        $xml = str_replace(array('<?xml version="1.0"?>'),array(''),
                $this->chartBuilder->build($mapWithGroupedValues, $years));
        $this->assertEquals($this->xml(),trim($xml));        
    }
     
    /**
     * @test
     */
    public function getChartOfTwoSubgroups(){
        $mapsWithGroupedValues = array($this->groupedList(), $this->secondGroupedList());
        $years = array(1989,1991);
        $xml = str_replace('<?xml version="1.0"?>','',
                $this->chartBuilder->build($mapsWithGroupedValues, $years));
        $this->assertEquals($this->xml(true),trim($xml));
    }
    
    /**
     * @test
     */
    public function getChartWithNumberOfValuesDifferents(){
        $mapsWithGroupedValues = $this->goupedListWithDifferentYears();
        $years = array(1989,1992);
        $xml = str_replace('<?xml version="1.0"?>','',
                $this->chartBuilder->build($mapsWithGroupedValues, $years));        
        $this->assertEquals($this->xml2(),trim($xml));
    }
    
    private function xml($dualY = false){
        if($dualY)
            $xml = '<chart bgColor="FFFFFF" PYAxisName="subgrupo" SYAxisName="subgrupo2">';
        else
            $xml = '<chart bgColor="FFFFFF" caption="subgrupo">';
        $xml .= '<categories>';
        $xml .= '<category label="1989"/>';
        $xml .= '<category label="1990"/>';
        $xml .= '<category label="1991"/>';
        $xml .= '</categories>';        
        if($dualY){            
            $xml .= $this->dataseries (true);
        }else
            $xml .= $this->dataseries();
        $xml .= '</chart>';       
        return $xml;
    }
    
    private function xml2(){
        $xml = '<chart bgColor="FFFFFF" caption="subgrupo">';
        $xml .= '<categories>';
        $xml .= '<category label="1989"/>';
        $xml .= '<category label="1990"/>';
        $xml .= '<category label="1991"/>';
        $xml .= '<category label="1992"/>';
        $xml .= '</categories>';
        
        $dataseries = '<dataset seriesName="origin-destiny">';
        $dataseries .= '<set value="0"/>';
        $dataseries .= '<set value="220"/>';
        $dataseries .= '<set value="285"/>';
        $dataseries .= '<set value="150"/>';        
        $dataseries .= '</dataset>';
        
        $dataseries .= '<dataset seriesName="origin2-destiny2">';
        $dataseries .= '<set value="188"/>';
        $dataseries .= '<set value="302"/>';
        $dataseries .= '<set value="254"/>';
        $dataseries .= '<set value="195"/>';
        $dataseries .= '</dataset>';        
        $xml .= $dataseries . '</chart>';
        
        return $xml;
    }
    
    private function dataseries($extra=false){
        $subgroup2 = $subgroup1 = '';
        if($extra){            
            $subgroup1 = 'subgrupo-';
            $subgroup2 = 'subgrupo2-';
        }
        $dataseries = '<dataset seriesName="'.$subgroup1.'origin-destiny">';
        $dataseries .= '<set value="150"/>';
        $dataseries .= '<set value="220"/>';
        $dataseries .= '<set value="285"/>';
        $dataseries .= '</dataset>';
        
        $dataseries .= '<dataset seriesName="'.$subgroup1.'origin2-destiny2">';
        $dataseries .= '<set value="188"/>';
        $dataseries .= '<set value="302"/>';
        $dataseries .= '<set value="254"/>';
        $dataseries .= '</dataset>';
        if($extra){
            $dataseries .= '<dataset seriesName="'.$subgroup2.'origin3-destiny2" parentYAxis="S">';
            $dataseries .= '<set value="150"/>';
            $dataseries .= '<set value="220"/>';
            $dataseries .= '<set value="285"/>';
            $dataseries .= '</dataset>';
        }
        return $dataseries;
    }
    
    private function newData($year, $value){
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
    
    private function newAnotherData($year, $value){
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
    
    private function newOtherData($year, $value){
        $subgroup = new Subgroup("subgrupo2");
        $font = new Font("fonte1");
        $type = new CoffeType("type3",2);
        $variety = new Variety("variety3",2);
        $origin = new Country("origin3",2);
        $destiny = new Country("destiny2",2);
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data->setValue($value);
        return $data;        
    }
        
    private function goupedListWithDifferentYears(){
        $map = new HashMap();
        $arrayList = new ArrayObject();        
        $arrayList->append($this->newData(1990,220));
        $arrayList->append($this->newData(1991,285));
        $arrayList->append($this->newData(1992,150));
        $map->put(0, $arrayList);        
        $arrayList = new ArrayObject();
        $arrayList->append($this->newAnotherData(1989,188));
        $arrayList->append($this->newAnotherData(1990,302));
        $arrayList->append($this->newAnotherData(1991,254));
        $arrayList->append($this->newAnotherData(1992,195));
        $map->put(1, $arrayList);
        return $map;        
    }
    
    private function groupedList(){        
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
        //$arrayList->append($this->newAnotherData(1992,195));
        $map->put(1, $arrayList);
        return $map;
    }
    
    private function secondGroupedList(){
        $map = new HashMap();
        $arrayList = new ArrayObject();
        $arrayList->append($this->newOtherData(1989,150));
        $arrayList->append($this->newOtherData(1990,220));
        $arrayList->append($this->newOtherData(1991,285));
        $map->put(0, $arrayList);        
        return $map;        
    }
    
}

?>
