<?php

/**
 * Description of DatacenterController
 *
 * @author Ramon
 */
class DatacenterController {

    /**
     * @var DatacenterRepository 
     */
    private $datacenterRepository;
    
    /**
     * @var DatacenterService 
     */
    private $datacenterService;
    
    /**
     * @var Statistic 
     */
    private $statistic;
    
    /**
     *
     * @var JsonResponse 
     */
    private $jsonResponse;
    
    /**
     *
     * @var DataGrouper 
     */
    private $grouper;
    
    /**     
     * @var TableBuilder 
     */
    private $tableBuilder;
    
    private $asJson = false;
    
    public function DatacenterController(DatacenterService $service, Statistic $statistic, 
            JsonResponse $jsonResponse, DataGrouper $grouper, TableBuilder $tableBuilder){
        $this->datacenterService = $service;
        $this->statistic = $statistic;
        $this->jsonResponse = $jsonResponse;
        $this->grouper = $grouper;
        $this->tableBuilder = $tableBuilder;
    }

    public function getValuesAsJson(){
        $this->asJson = true;
    }

    public function buildTableAsJson($subgroup, $font, $type, $variety, $origin, $destiny,array $year = null) {
        $values = $this->getValues($subgroup, $font, $type, $variety, $origin, $destiny,$year);
        if($values instanceof HashMap){
            $listValues = $values->values();
            $group1 = $this->grouper->groupDataValues($this->getListAsAnArrayObject($listValues->offsetGet(0)));
            $group2 = $this->grouper->groupDataValues($this->getListAsAnArrayObject($listValues->offsetGet(1)));
            $groupedValues = array($group1, $group2);
        }else{
            $groupedValues = $this->grouper->groupDataValues($this->getListAsAnArrayObject($values));
        }        
        return $this->tableBuilder->buildAsJson($groupedValues, array(1990,1992)); 
    }
    
    private function getListAsAnArrayObject($list){
        if($list instanceof ArrayIterator){
            $list = new ArrayObject($list->getArrayCopy());
        }
        return $list;
    }
 
    public function getValues($subgroup, $font, $type, $variety, $origin, $destiny,array $years = null) {
        if(!$this->anyValueIsAnArray($subgroup, $font, $type, $variety, $origin, $destiny)){
            return $this->getValuesWithSimpleParams($subgroup, $font, $type, $variety, $origin, $destiny,$years);
        }else{            
            if(is_array($subgroup)){                
                return $this->getValuesFilteringByTwoSubgroups($subgroup, $font, $type, $variety, $origin, $destiny);
            }else{                
                return $this->getValuesWithMultipleParams($subgroup, $font, $type, $variety, $origin, $destiny);
            }
        }
    }
    
    private function anyValueIsAnArray($subgroup, $font, $type, $variety, $origin, $destiny){
        return (is_array($subgroup) || is_array($font) || is_array($type) || is_array($variety) 
                || is_array($origin) || is_array($destiny));
    }
    
    public function getValuesWithSimpleParams($subgroup, $font, $type, $variety, $origin, $destiny,array $years = null) {
        $values = $this->datacenterService->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font,$years);
        if($this->asJson)
            return $this->toJson($values);        
        return $values;
    }
        
    public function getValuesWithMultipleParams($subgroup, $font, $type, $variety, $origin, $destiny,array $years = null) {
        $values = $this->datacenterService->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font,$years);
        if($this->asJson)
            return $this->toJson($values);        
        return $values;
    }
        
    public function getValuesFilteringByTwoSubgroups(array $subgroup, $font, $type, $variety, $origin, $destiny, array $years = null) {
        $values = $this->datacenterService->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font,$years);        
        if($this->asJson)
            return $this->hashMapFilteredToJSON($values);
        return $values;
    }
    
    public function calculateSampleStandardDeviation($group){
        $values = $this->datacenterRepository->getValuesFromAGroup($group);
        $standarDeviation = $this->statistic->sampleStandardDeviation($values);
        
        return $this->jsonResponse->response(true, null)
                ->addValue("value", $standarDeviation)
                ->withoutHeader()
                ->serialize();
    }
    
    private function hashMapFilteredToJSON(Map $map){        
        $json = '{';
        $listValues = $map->values()->getIterator();
        $n = 1;
        while($listValues->valid()){
            $json .= '"subgroup_'.$n++.'":';
            $json .= $this->toJson($listValues->current()->getIterator());
            if(($n-1) < $listValues->count())
                $json .= ',';
            $listValues->next();
        }
        $json .= '}';
        return $json;
    }
    
    private function toJson(ArrayIterator $list){
        $json = "[";
        while($list->valid()){
            $json .= $list->current()->toJson();
            $json .= ",";
            $list->next();
        }
        $json = substr($json, 0, -1);
        $json .= "]";
        return $json;
    }
}
?>
