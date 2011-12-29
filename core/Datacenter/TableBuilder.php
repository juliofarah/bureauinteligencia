<?php
/**
 * Description of TableBuilder
 *
 * @author Ramon
 */
class TableBuilder {

    /**
     * The param $mapValues must be the map with grouped values. In this map
     * each position contains an ArrayObject with grouped Data .
     * @param $mapWithGroupedValues 
     */
    public function buildAsJson($mapWithGroupedValues,array $years) {        
        $json = '[';        
        if(is_array($mapWithGroupedValues)){            
            $json .= '{'.$this->buildSimpleTable($mapWithGroupedValues[0], $years,1).'}';
            $json .= ',';
            $json .= '{'.$this->buildSimpleTable($mapWithGroupedValues[1], $years,2).'}';
        }else{
            $json .= '{'.$this->buildSimpleTable($mapWithGroupedValues,$years).'}';
        }
        $json .= ']';
        echo '\n\n'.$json;
        return $json;
    }
    
    private function buildSimpleTable(Map $mapWithGroupedValues,array $years, $i = 1){
        $json = $this->initTableJson($i).'{';
        $json .= $this->thead($years);
        $json .= ',"tbody":';
        $json .= $this->buildTbodyJson($mapWithGroupedValues,$years);        
        $json .= '}';        
        return $json;
    }
    
    private function initTableJson($i = 1){
        $json = '"tabela_'.$i.'":';
        return $json;
    }
    
    private function thead(array $years){
        $thead = '"thead":[';
        $thead .= '{"th":"Variedade"},{"th":"Tipo"},{"th":"Origem"},{"th":"Destino"},';
        $thead .= $this->years($years);
        $thead .= ']';
        return $thead;
    }
    
    private function years(array $years){
        $thYears = '';
        foreach($this->arrayYears($years) as $year){
            $thYears .= '{"th":"'.$year.'"},'; 
        }
        return substr($thYears,0,-1);
    }
    
    private function buildTbodyJson(Map $values, array $years){
        $list = $values->values();
        $groupsNumber = $list->count();
        $json = '[';
        for($i = 0; $i < $groupsNumber; $i++){
            $group = $list->offsetGet($i);
            $data = $group->offsetGet(0);
            $json .= $this->setProperties($group, $data, $years);
            if($i < $groupsNumber-1)
                $json .= ',';
        }
        $json .= ']';
        return $json;
    }
    
    private function setProperties(ArrayObject $group,Data $data, array $years){
        $properties = '{';
        $properties .= '"variety":"'.$data->getVarietyName().'",';
        $properties .= '"type":"'.$data->getTypeName().'",';
        $properties .= '"origin":"'.$data->getOriginName().'",';
        $properties .= '"destiny":"'.$data->getDestinyName().'",';
        $properties .= '"values":'.$this->listValues($group, $years);
        $properties .= '}';
        return $properties;
    }
    
    private function listValues(ArrayObject $group,array $years){
        $values = '[';        
        $values .= $this->listValuesVerifyingTheYearOfThat($group, $years);
        $values .= ']';
        return $values;
    }
    
    private function listValuesVerifyingTheYearOfThat(ArrayObject $group, array $years){
        $value = '';        
        foreach($this->arrayYears($years) as $ys){            
            $foundValueOfThisYear = null;
            foreach($group as $data){
                if($data->getYear() == $ys){                    
                    $foundValueOfThisYear = $data->getValue();
                }
            }                     
            $value .= $this->addValueToJsonIfThereIsSomeValueToThisYear($foundValueOfThisYear);
        }
        $value = substr($value,0,-1);
        return $value;
    }
    
    private function addValueToJsonIfThereIsSomeValueToThisYear($foundValueOfThisYear){
        if(!is_null($foundValueOfThisYear)){
            return '{"value":'.$foundValueOfThisYear.'},';
        }else{
            return '{"value":"-"},';
        }        
    }
    
    private function arrayYears(array $years){
        $listYears = array();
        for($y = $years[0]; $y<=$years[1];$y++){
            array_push($listYears, $y);
        }
        return $listYears;
    }
}

?>
