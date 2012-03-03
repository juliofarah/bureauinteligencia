<?php
/**
 *
 * @author raigons
 */
abstract class Report {
    
    /**
     * @var Builder 
     */
    protected $builder;
    
    /**
     * @var JsonResponse
     */
    protected $jsonResponse;
        
    public function Report(Builder $builder, JsonResponse $jsonReponse){
        $this->builder = $builder; 
        $this->jsonResponse = $jsonReponse;
    }   
    
    public function getReport($values, array $years, DataGrouper $grouper){
        return $this->getBuiltReportAsJson($this->buildReport($values, $years, $grouper));
    }        
    
    public function getBuiltReportAsJson($response){
        return $this->buildResponse($response);
    }
    
    public function getDistinctGroupsReport($values1, $values2, array $years, DataGrouper $grouper){
        return $this->buildResponse($this->buildReportForDistinctGroups($values1, $values2,$years, $grouper));
    }
    
    private function buildReport($values, array $years, DataGrouper $grouper){
        if($values instanceof HashMap){            
            $listValues = $values->values();
            $group1 = $grouper->groupDataValues($this->getListAsAnArrayObject($listValues->offsetGet(0)));
            $group2 = $grouper->groupDataValues($this->getListAsAnArrayObject($listValues->offsetGet(1)));
            $groupedValues = array($group1, $group2);            
        }else{
            $groupedValues = $grouper->groupDataValues($this->getListAsAnArrayObject($values));
        }
        return $this->buildForGroupedData($groupedValues, $years);
    }
    
    private function buildReportForDistinctGroups($valuesGroup1, $valuesGroup2, array $years, DataGrouper $grouper){
        $group1 = $grouper->groupDataValues($valuesGroup1);
        $group2 = $grouper->groupDataValues($valuesGroup2);
        return $this->buildForGroupedData(array($group1, $group2), $years);
    }
    
    private function getListAsAnArrayObject($list){
        if($list instanceof ArrayIterator){
            $list = new ArrayObject($list->getArrayCopy());
        }
        return $list;
    }
    
    protected abstract function buildResponse($response);
    
    protected abstract function buildForGroupedData($groupedValues, array $years);
}

?>
