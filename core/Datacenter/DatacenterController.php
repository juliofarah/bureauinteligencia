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
    
    public function DatacenterController(DatacenterService $service, Statistic $statistic, JsonResponse $jsonResponse){
        $this->datacenterService = $service;
        $this->statistic = $statistic;
        $this->jsonResponse = $jsonResponse;
    }

    public function getValuesWithSimpleParams($subgroup, $font, $type, $variety, $origin, $destiny) {
        $values = $this->datacenterService->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font);
        return $this->toJson($values);
    }

    public function getValuesWithMultipleParams($subgroup, $font, $type, $variety, $origin, $destiny) {
        $values = $this->datacenterService->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font);        
        return $this->toJson($values);
    }
        
    public function getValuesFilteringByTwoSubgroups(array $subgroup, $font, $type, $variety, $origin, $destiny) {
        $values = $this->datacenterService->getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font);        
        return $this->hashMapFilteredToJSON($values);
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
