<?php
/**
 * Description of TableBuildr
 *
 * @author Ramon
 */
abstract class TableBuilder implements Builder{   
    
    protected function buildSimpleTable(Map $groupedValues, $arrays, $i=1){
        $this->initTable($i);
    }        

    protected abstract function initTable($i = 1);        
    
    protected function titles(array $years){
        $this->setTitles($years);
    }
    
    protected function setTitles(array $years){
        $this->setDefinedTitles(array("Variedade", "Tipo", "Origem", "Destino"), $years);
    }
    
    protected abstract function setDefinedTitles(array $definedTitles, array $years);    
 
    protected function years(array $years){
        foreach($this->arrayYears($years) as $year){
            $this->buildTitleYears($year);
        }
        $this->config();
    }
        
    protected abstract function config();

    protected abstract function buildTitleYears($year);
    
    protected function addValuesToARow(Map $values, array $years){
        $list = $values->values();
        $groupsNumber = $list->count();        
        for($i = 0; $i < $groupsNumber; $i++){
            $group = $list->offsetGet($i);
            $data = $group->offsetGet(0);
            $this->setValues($group, $data, $years);
        }
        $this->config();
    }
    
    protected function setValues(ArrayObject $group, Data $data, $years){
        $this->setProperties($group, $data, $years);                
    }
    
    protected abstract function setProperties(ArrayObject $group, Data $data, array $years);

    protected function listValuesVerifyingTheYearOfThat(ArrayObject $group, array $years){        
        foreach($this->arrayYears($years) as $ys){            
            $foundValueOfThisYear = null;
            foreach($group as $data){
                if($data->getYear() == $ys){                    
                    $foundValueOfThisYear = $data->getValue();
                }
            }
            $this->addValueIfThereIsSomeValueToThisYear($foundValueOfThisYear);
        }
        $this->config();
    }
    
    protected abstract function addValueIfThereIsSomeValueToThisYear($foundValueOfThisYear);
    
    protected function arrayYears(array $years){
        $listYears = array();
        for($y = $years[0]; $y<=$years[1];$y++){
            array_push($listYears, $y);
        }
        return $listYears;
    }
}

?>
