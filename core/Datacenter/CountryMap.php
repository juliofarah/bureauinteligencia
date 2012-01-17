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
    }
    
    public function getCountryId($countryName){
        return $this->map->get($countryName);
    }
}

?>
