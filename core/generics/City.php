<?php
/**
 * Description of City
 *
 * @author ramon
 */
class City {
    
    private $id;
    
    private $name;
    
    public function City($name, $id = null){
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
        return array("id" => $this->id(), "name" => $this->name());
    }
    
    public function toJson(){
        return json_encode($this->toArray());
    }
        
}

?>
