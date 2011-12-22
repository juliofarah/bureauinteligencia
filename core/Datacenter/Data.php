<?php

/**
 * Description of Data
 *
 * @author Ramon
 */
class Data {
    
    private $year;
    
    /**
     *
     * @var Subgroup 
     */
    private $subgroup;
    
    /**     
     * @var Font 
     */
    private $font;
    
    /**
     *
     * @var CoffeType 
     */
    private $type;
    
    /**
     *
     * @var Variety
     */
    private $variety;
    
    /**
     *
     * @var Country
     */
    private $origin;
    
    /**
     *
     * @var Country 
     */
    private $destiny;
    
    private $value;
    
    public function Data($year, $subgroup, $font, $type, $variety, $origin, $destiny){
        $this->year = $year;
        $this->subgroup = $subgroup;
        $this->font = $font;
        $this->type = $type;
        $this->variety = $variety;
        $this->origin = $origin;
        $this->destiny = $destiny;
    }
    
    public function setValue($value){
        $this->value = $value;
    }
    
}

?>
