<?php
/**
 * Mapa para a tradução dos códigos
 * @author ramon
 */
class CodeMap {
    
    private $CodeMap = array();
    
    public function CodeMap(){                
        $this->CodeMap = new HashMap();
        $this->initMap();
    }

    private function initMap(){
        $this->CodeMap->put("ICF", "Café");
        $this->CodeMap->put("CCM", "Milho");
        $this->CodeMap->put("SOJ", "Soja");
        $this->CodeMap->put("BGI", "Boi Gordo");
        $this->CodeMap->put("WDL", "Dólar Fut.");
        $this->CodeMap->put("ISU", "Açúcar");
        $this->CodeMap->put("ETN", "Etanol");
    }

    /**
     * @return MyHashMap
     */
    public function getCodeMap(){
        return $this->CodeMap;
    }
    
    /**
     * @return String
     */
    public function getProduct($code){
        return $this->CodeMap->get($this->splitCode($code));        
    }

    private function splitCode($code){
        return substr($code, 0, 3);
    }

}
?>
