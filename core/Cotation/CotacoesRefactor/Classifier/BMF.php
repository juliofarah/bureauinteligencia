<?php

/**
 * Description of BMF
 *
 * @author ramon
 */
class BMF extends Cotation {

    public function BMF(DateMap $dateMap){
        $this->name = "BMF";
        $this->type = "BMF";
        parent::Cotation($dateMap);        
    }

    public function getMonth() {        
        return $this->dateMap->getMonth(substr($this->jsonInfo->codigo, 3, 1)).
                "/".substr($this->jsonInfo->codigo, 4);
    }    
}
?>
