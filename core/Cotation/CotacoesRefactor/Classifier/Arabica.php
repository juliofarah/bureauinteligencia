<?php

/**
 * Description of BicaDura
 *
 * @author ramon
 */
class Arabica extends Cotation {

    /**
     * @var Map
     */
    private $types;

    public function Arabica(DateMap $map){
        parent::Cotation($map);
        $this->type = "Arabica";
        $this->types = new HashMap();
        $this->types();        
        //$this->name = $this->name($this->jsonInfo->codigo);        
    }

    private function types(){        
        $this->types->put("CFDUR5 SMG", "Bica Fina MGerais");
        $this->types->put("CFDUR6 CER", "Bica Dura T.6 Cerrado-MG");
        $this->types->put("CFDUR6 GAR", "Bica Dura T.6 Garça-SP");
        $this->types->put("CFDESP BAH", "Despolpado VConquista-BA");
        $this->types->put("CFDUR6 MOG", "Bica Dura T.6 Mogiana-SP");
        $this->types->put("CFDUR6 PIN", "Bica Dura T.6 Pinhal-ES");
        $this->types->put("CFDUR6 SMG", "Bica Dura T.6 Sul Minas");
        $this->types->put("CFDUR6 ZOM", "Bica Dura T.6/7 ZMata-MG");
        $this->types->put("CFDUR7 BAH", "Bica Dura T.6/7 VConquista-BA");
        $this->types->put("CFDUR7 PRN", "Bica Dura T.6/7 Norte-PR");
        $this->types->put("CFDURI ZOM", "Bica Dura/Riada ZMata-MG");
    }

    private function getNameByCode($code){
        return $this->types->get($code);
    }

    public function setName($code){
        $this->name = $this->getNameByCode($code);
    }

    public function getMonth() {
        return date("M/y");
    }
}
?>
