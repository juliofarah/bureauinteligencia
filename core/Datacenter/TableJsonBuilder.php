<?php
/**
 * Description of TableJsonBuilder
 *
 * @author Ramon
 */
class TableJsonBuilder extends TableBuilder{//implements Builder{
    
    protected $json;    
    
    public function TableJsonBuilder(){
        $this->json = '';
    }

    /**
     * The param $mapValues must be the map with grouped values. In this map
     * each position contains an ArrayObject with grouped Data .
     * @param $mapWithGroupedValues 
     */
    public function build($mapWithGroupedValues,array $years) {        
        $this->json = '[';
        if(is_array($mapWithGroupedValues)){            
            $this->buildMultiTables($mapWithGroupedValues, $years);
        }else{
            $this->buildSimpleTable($mapWithGroupedValues,$years);
        }
        $this->json .= ']';
        return $this->json;
    }
    
    private function buildMultiTables(array $mapWithGroupedValues, array $years){
        $i = 1;        
        foreach($mapWithGroupedValues as $groupedValues){            
            $this->buildSimpleTable($groupedValues, $years,$i++);
            $this->json .= ',';
        }
        $this->config();
    }
    
    protected function buildSimpleTable(Map $mapWithGroupedValues, array $years, $i = 1){
        $this->json .= '{';
        //$this->initTable($i);
        //$this->json .= '{';
        $this->titles($years);
        $this->json .= ',"tbody":[';        
        $this->addValuesToARow($mapWithGroupedValues,$years);        
        $this->json .= ']'; 
        //$this->json .= '}';
        $this->json .= '}';
    }

    protected function initTable($i = 1){        
        $this->json .= '"tabela_'.$i.'":';        
    }
    
    protected function setDefinedTitles(array $definedTitles, array $years = null){
        $this->json .= '"thead":[';
        foreach($definedTitles as $title){
            $this->json .= '{';
            $this->json .= '"th":"'.$title.'"';
            $this->json .= '},';
        }        
        if(!is_null($years))
            $this->years($years);
        else
            $this->config();
        $this->json .= ']';;
    }
    
    protected function config(){
        if(substr($this->json, -1) != '[' && substr($this->json, -1) != ']')
            $this->json = substr($this->json,0,-1);       
    }
    
    protected function buildTitleYears($year){
        $this->json .= '{"th":"'.$year.'"},';
    }
    
    protected function setProperties(ArrayObject $group, Data $data, array $years){        
        $this->json .= '{';
        $this->json .= '"variety":"'.$data->getVarietyName().'",';
        $this->json .= '"type":"'.$data->getTypeName().'",';
        $this->json .= '"origin":"'.utf8_decode($data->getOriginName()).'",';
        $this->json .= '"destiny":"'.utf8_decode($data->getDestinyName()).'",';
        $this->json .= '"values":'; $this->listValues($group, $years);
        $this->json .= '},';        
    }
    
    protected function listValues(ArrayObject $group,array $years){
        $this->json .= '[';        
        $this->listValuesVerifyingTheYearOfThat($group, $years);
        $this->json .= ']';       
    }
    
    protected function addValueIfThereIsSomeValueToThisYear($foundValueOfThisYear){
        if(!is_null($foundValueOfThisYear)){
            $this->json .= '{"value":'.$foundValueOfThisYear.'},';
        }else{
            $this->json .= '{"value":"-"},';
        }        
    }
}

?>
