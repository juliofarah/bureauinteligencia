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

    public function toArray(){
        $array = array();
        if($this->year != null)
            $array['year'] = $this->getYear();
        if($this->subgroup != null)
            $array['subgroup'] = $this->subgroup->toArray();
        if($this->font != null)
            $array['font'] = $this->font->toArray();
        if($this->type != null)
            $array['type'] = $this->type->toArray();
        if($this->variety != null)
            $array['variety'] = $this->variety->toArray();
        if($this->origin != null)
            $array['origin'] = $this->origin->toArray();
        if($this->destiny != null)
            $array['destiny'] = $this->destiny->toArray();
        return $array;
    }
    
    public function toJson() {
       return json_encode($this->toArray());
    }
    
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
    
    public function getValue(){
        return $this->value;
    }
    
    public function getYear(){
        return $this->year;
    }
    
    public function getVarietyName(){
        return $this->variety->name();
    }
    
    public function getOriginName(){
        return $this->origin->name();
    }
    
    public function getDestinyName(){
        return $this->destiny->name();
    }
    
    public function getVariety(){
        return $this->variety->name();
    }
}
?>
