<?php

/**
 * Description of Group
 *
 * @author Ramon
 */
class Group {

    private $id;
    
    private $name;
    
    public function Group($name, $id = null){
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
        $array = array("id" => $this->id(), "nome" => utf8_decode($this->name()));
        return $array;
    }
    
    public function toJson(){
        return json_encode($this->toArray());
    }
}

?>
