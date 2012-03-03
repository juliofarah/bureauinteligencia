<?php
/**
 * Description of ChartReport
 *
 * @author raigons
 */
class ChartReport extends Report{
    
    private $chartType;
    
    protected function buildForGroupedData($groupedValues, array $years) {
        if(is_array($groupedValues)){            
            if($groupedValues[0]->values()->count() > 0 && $groupedValues[1]->values()->count() > 0){
                $this->chartType = "MSColumn3DLineDY.swf";
            }else{
                $this->chartType = "MSLine.swf";
            }            
        }else{
            $this->chartType = "MSLine.swf";
        }        
        return $this->builder->build($groupedValues, $years);
    }

    protected function buildResponse($response) {
        $xmlChart = $response;
        $xmlChart = str_replace("\"", "'", trim($xmlChart));
        $this->jsonResponse->response(true, null)->addValue("chart", trim($xmlChart));        
        $this->jsonResponse->addValue("typeChart", $this->chartType);
        return $this->jsonResponse->withoutHeader()->serialize();            
    }
}

?>
