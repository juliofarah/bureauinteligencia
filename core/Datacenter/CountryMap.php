<?php

/**
 * Description of CountryMap
 *
 * @author Ramon
 */
class CountryMap {
    
    /**
     *
     * @var HashMap 
     */
    private $map;
    
    public function CountryMap(){
        $this->map = new HashMap();
        $this->populateMap();
    }
    
    private function populateMap(){
        $this->map->put("Brasil", 1);
        $this->map->put("Colombia",2);
        $this->map->put("Colômbia",2);
        $this->map->put("Vietnã", 3);
        $this->map->put("Guatemala",4);
        $this->map->put("Peru", 5);
        $this->map->put("Quênia", 6);
        $this->map->put("Outros", 7);
    }
    
    public function getCountryId($countryName){
        if($this->map->containsKey($countryName))
            return $this->map->get($countryName);
        return $this->getCountryId("Outros");
    }
}

?>
