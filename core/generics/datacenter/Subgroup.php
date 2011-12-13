<?php

/**
 * Description of Subgroup
 *
 * @author Ramon
 */
class Subgroup {
    
    private $id;
    
    private $name;
    
    public function Subgroup($name = null, $id = null){
        $this->name = $name;
        $this->id = $id;
    }
    
    public function id(){
        return $this->id;
    }
    
    public function name(){
        return $this->name;
    }
    
    public function toArray(){
        return array("id"=>$this->id(),"name"=>utf8_decode($this->name()));
    }
    
    public function toJson(){
        return json_encode($this->toArray());
    }
}

?>
