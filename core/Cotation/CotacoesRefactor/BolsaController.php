<?php
/**
 * @author RAMONox
 */
class BolsaController {

    private $bolsa;
    private $dao;

    public function BolsaController(Bolsa $bolsa, BolsaDao $dao){
        $this->bolsa = $bolsa;
        $this->dao = $dao;
    }
    /**
     * @return Bolsa
     */
    public function getBolsa(){
        $this->bolsa->setCotacoes($this->dao->getCotacoes());
        return $this->bolsa;
    }
}
?>
