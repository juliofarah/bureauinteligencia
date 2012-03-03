<?php

/**
 * Description of TableReport
 *
 * @author raigons
 */
class TableReport extends Report{
    
    private $jsonParam = "tabela";
            
    public function setJsonParam($jsonParam){
        $this->jsonParam = $jsonParam;
    }
    //put your code here    
    protected function buildForGroupedData($groupedValues, array $years) {
        return $this->builder->build($groupedValues, $years);
    }
    
    protected function buildResponse($response) {
        $jsonTable = trim($response);
        $jsonTable = utf8_encode($jsonTable);
        $jsonTable = json_decode($jsonTable);
        return $this->jsonResponse->response(true, null)->addValue($this->jsonParam,$jsonTable)->withoutHeader()->serialize();        
    }
}
?>
