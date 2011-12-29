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
    
    private $asJson = false;
    
    public function DatacenterController(DatacenterService $service, Statistic $statistic, JsonResponse $jsonResponse){
        $this->datacenterService = $service;
        $this->statistic = $statistic;
        $this->jsonResponse = $jsonResponse;
    }

    public function getValuesAsJson(){
        $this->asJson = true;
    }
    
    public function getValues($subgroup, $font, $type, $variety, $origin, $destiny) {
        if(!$this->anyValueIsAnArray($subgroup, $font, $type, $variety, $origin, $destiny)){
            return $this->getValuesWithSimpleParams($subgroup, $font, $type, $variety, $origin, $destiny);
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
    
    public function getValuesWithSimpleParams($subgroup, $font, $type, $variety, $origin, $destiny) {
        $values = $this->datacenterService->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font);
        if($this->asJson)
            return $this->toJson($values);        
        return $values;
    }

    public function getValuesWithMultipleParams($subgroup, $font, $type, $variety, $origin, $destiny) {
        $values = $this->datacenterService->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font);
        if($this->asJson)
            return $this->toJson($values);        
        return $values;
    }
        
    public function getValuesFilteringByTwoSubgroups(array $subgroup, $font, $type, $variety, $origin, $destiny) {
        $values = $this->datacenterService->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font);        
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
