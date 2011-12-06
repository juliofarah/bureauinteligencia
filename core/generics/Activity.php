<?php
/**
 * Description of Activity
 *
 * @author ramon
 */
class Activity {
    
    private $id;
    
    private $name;
    
    public function Activity($name = null, $id = null){
        $this->id = $id;
        $this->name = $name;
    }
    
    public function id(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function name(){
        return $this->name;
    }
    
    public function toArray(){
        $array = array("name" => utf8_encode($this->name()), "id" => $this->id());
        return $array;
    }
    
    public function toJson(){
        return json_encode($this->toArray());
    }
}

?>
