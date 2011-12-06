<?php
/**
 * Description of DateMap
 *
 * @author ramon
 */
class DateMap {
    private $map = array();

    public function DateMap(){                
        $this->map = new HashMap();
        $this->initMap();
    }

    private function initMap(){
        $this->map->put("F", "Jan");
        $this->map->put("G", "Fev");
        $this->map->put("H", "Mar");
        $this->map->put("J", "Abr");
        $this->map->put("K", "Mai");
        $this->map->put("M", "Jun");
        $this->map->put("N", "Jul");
        $this->map->put("Q", "Ago");
        $this->map->put("U", "Set");
        $this->map->put("V", "Out");
        $this->map->put("X", "Nov");
        $this->map->put("Z", "Dez");
    }

    /*public function getMounth($cod){
        return $this->map->get($this->splitCodeMouth($cod))."/".substr($cod,4);
    }*/

    public function getMonth($key){
        return $this->map->get($key);
    }
    /**
     * @return HashMap
     */
    public function getMounthMap(){
        return $this->map;
    }
    /**
     *
     * @return ArrayObject 
     */
    public function getMounths(){
        return $this->map->values();
    }

    private function splitCodeMouth($cod){
        return substr($cod, 3, 1);
    }
    
}
?>
