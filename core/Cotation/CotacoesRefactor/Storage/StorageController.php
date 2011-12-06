<?php

/**
 * Description of StorageController
 *
 * @author ramon
 */
class StorageController {
    
    /**
     *
     * @var StorageDao 
     */
    private $dao;

    public function StorageController(StorageDao $dao){
        $this->dao = $dao;
    }
    
    /**
     *
     * @param type $code
     * @return ArrayIterator 
     */
    public function getStorageQuotations($code, $period){
        $cotations = $this->dao->getValuesFromAnAtive($code, $period);
        return $cotations;
    }
    
    public function getStorageQuotationsToJson($code){
        $cotations = $this->dao->getValuesFromAnAtive($code);
        return $this->buildJsonArray($cotations);
    }
    
    private function buildJsonArray(ArrayIterator $cotations){
        $json = '[';
        while($cotations->valid()){
            $json .= $cotations->current()->toJson().',';
            $cotations->next();
        }
        $json = substr($json, 0, -1);
        $json .= ']';
        return $json;
    }
}

?>
