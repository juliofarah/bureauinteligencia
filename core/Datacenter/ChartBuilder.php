<?php

/**
 * Description of ChartBuilder
 *
 * @author Ramon
 */
class ChartBuilder implements Builder {

    /**
     *
     * @var XmlMultiSeriesCombinationColumnLine 
     */
    private $xml;
    
    public function ChartBuilder(XmlMultiSeriesCombinationColumnLine $xml) {
        $this->xml = $xml;
    }
    
    public function build($mapWithGroupedValues, array $years) {        
        $this->years($years);
        if(is_array($mapWithGroupedValues)){
            $this->setMultigroupsValues($mapWithGroupedValues);
            $this->setMultiChartValues($mapWithGroupedValues); 
        }else    
            $this->setValues($mapWithGroupedValues);
        return $this->xml->buildXml("test.xml");
    }
        
    private function years(array $years){
        foreach($this->arrayYears($years) as $year){
            $this->xml->addCategory($year);
        }
    }
    
    private function setMultigroupsValues(array $mapWithGroupedValues){
        $this->xml->setPYAxisName($mapWithGroupedValues[0]->get(0)->offsetGet(0)->getSubgroupName());
        $this->xml->setSYAxisName($mapWithGroupedValues[1]->get(0)->offsetGet(0)->getSubgroupName());        
    }
    
    private function setMultiChartValues(array $mapWithGroupedValues){
        $i = 1;
        foreach($mapWithGroupedValues as $mapWithValues){
            if($i++ == 2)
                $this->setValues($mapWithValues,true,true);
            else
                $this->setValues ($mapWithValues,true);
        }
    }
    
    private function setValues(Map $mapGroupedData,$dualY=false,$setToAxis=false){        
        $groups = $mapGroupedData->values();
        foreach($groups as $groupedData){
            foreach($groupedData as $data){
                if($dualY){
                    $seriesName = $data->getSubgroupName().'-'.$data->getOriginName().'-'.$data->getDestinyName();
                    $this->xml->setValue ($data->getValue(),$seriesName);
                    if($setToAxis) $this->xml->setLineToAnAxis ($seriesName, "S");                        
                }else
                    $this->xml->setValue($data->getValue(), $data->getOriginName().'-'.$data->getDestinyName());
            }   
        }
    }
    
    private function arrayYears(array $years){
        $listYears = array();
        for($y = $years[0]; $y <= $years[1]; $y++){
            array_push($listYears, $y);
        }
        return $listYears;
    }
}

?>
