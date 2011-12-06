<?php

/**
 * Description of NewYork
 *
 * @author ramon
 */
class NewYork extends Cotation {
    
    public function NewYork(DateMap $map){
        $this->name = "NY";
        $this->type = "NY";
        parent::Cotation($map);
    }

    public function getMonth() {
        return $this->dateMap->getMonth(substr($this->jsonInfo->codigo, 2, 1)).
            "/1".substr($this->jsonInfo->codigo, 3);
    }
}
?>
