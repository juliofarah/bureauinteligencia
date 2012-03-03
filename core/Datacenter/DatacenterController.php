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
     * @var BuilderFactory 
     */
    private $builderFactory;
    
    private $asJson = false;
    
    private $chartType;
    
    /**
     * @var Report
     */
    private $report;
    
    public function DatacenterController(DatacenterService $service, Statistic $statistic, 
            JsonResponse $jsonResponse, DataGrouper $grouper, BuilderFactory $factory){
        $this->datacenterService = $service;
        $this->statistic = $statistic;
        $this->jsonResponse = $jsonResponse;
        $this->grouper = $grouper;        
        $this->builderFactory = $factory;
        
        //$this->report = $report;
    }
    
    public function setReport(Report $report){
        $this->report = $report;
    }
    
    private function getBuilder($type) {
        return $this->builderFactory->getBuilder($type);
    }
    
    public function getValuesAsJson(){
        $this->asJson = true;
    }
    
    public function getReport(DataParam $dataParam, array $years){
        $asJson = $this->asJson;
        $this->asJson = false;
        $values = $this->getValues($dataParam,$years);
        $this->asJson = $asJson;
        return $this->report->getReport($values, $years, $this->grouper);
    }
    
    public function getDistinctGroupReport($g1, $g2, array $years){
        $values1 = $this->getValues($g1,$years);
        $values2 = $this->getValues($g2,$years);
        $values1 = $this->getListAsAnArrayObject($values1);
        $values2 = $this->getListAsAnArrayObject($values2);
        return $this->report->getDistinctGroupsReport($values1, $values2,$years,$this->grouper);
    }           
    
    //POST ://datacenter/save
    public function saveValues(ExcelInputFile $excelInputFile, $subgroup, $font, $destiny, $coffeType, $variety, $typeCountry = null){
        if(SessionAdmin::isLogged()){
            try{
                if($this->datacenterService->insertValues($excelInputFile, $subgroup, $destiny, $coffeType, $variety, $font,$typeCountry)){
                    return $this->jsonResponse->response(true, "Dados inseridos com sucesso!")->serialize();
                }else{
                    $message = "Dados não inseridos. Verifique a possibilidade de já existirem dados referentes a esta planilha";
                    return $this->jsonResponse->response(true, $message)->serialize();
                }
            }catch(Exception $e){
                return $this->jsonResponse->response(false, $e->getMessage())->serialize();
            }
        }else{
            throw new LoginException();
        }
    }
    
    private function getListAsAnArrayObject($list){
        if($list instanceof ArrayIterator){
            $list = new ArrayObject($list->getArrayCopy());
        }
        return $list;
    }
    
    public function getValues(DataParam $params,array $years = null) {
        if(!$params->anyValueIsArray()){
            return $this->getValuesWithSimpleParams($params,$years);
        }else{            
                return $this->getValuesWithMultipleParams($params,$years);
        }
    }
    
    public function getValuesWithSimpleParams(DataParam $params, array $years){
        $values = $this->datacenterService->getValuesWithSimpleFilter($params,$years);        
        if($this->asJson)
            return $this->toJson($values);        
        return $values;
    }
   
    public function getValuesWithMultipleParams(DataParam $params, array $years){
        $values = $this->datacenterService->getValuesFilteringWithMultipleParams($params,$years);
        if($this->asJson){
            if($values instanceof HashMap)
                return $this->hashMapFilteredToJSON($values);
            return $this->toJson($values);
        }
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
