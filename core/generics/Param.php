<?php

/**
 * Description of Param
 *
 * @author Ramon
 */
abstract class Param {
    
    private $id;
    
    private $name;
    
    public function Param($name, $id = null){
        $this->name = $name;
        $this->id = $id;
    }
    
    public function name(){
        return $this->name;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function id(){
        return $this->id;
    }
    
    public function toArray(){
        return array('id'=>$this->id(),'name'=> utf8_decode($this->name));
    }
    
    public function toJson(){
        return json_encode($this->toArray());
    }
    
    public abstract function getType();
}

?>
