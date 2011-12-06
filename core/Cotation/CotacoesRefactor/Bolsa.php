<?php
/**
 * @author RAMONox
 */
class Bolsa {
    private $cotacoes; #lista das cotações

    public function Bolsa() {        
    }
    
    /**
     * @return HashMap
     */
    public function getCotacoes(){
        return $this->cotacoes;
    }

    public function setCotacoes($cotacoes){
        $this->cotacoes = $cotacoes;
    }
}
?>
