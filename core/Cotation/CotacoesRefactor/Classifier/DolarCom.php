<?php

/**
 * Description of DolarCom
 *
 * @author ramon
 */
class DolarCom extends Cotation {
    
    public function DolarCom(DateMap $dateMap){
        $this->name = "DÓLAR";
        $this->type = "Dolar";
        parent::Cotation($dateMap);
    }

    public function getMonth() {
        //return $this->dateMap->getMonth(subst)
        return date("M/y");
    }
}
?>
