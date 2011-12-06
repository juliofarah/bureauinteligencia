<?php
/**
 * Description of PublicationType
 *
 * @author Ramon
 */
class PublicationType {
    
    private $id;
    
    private $name;
    
    public function PublicationType($name = null, $id = null){
        $this->name = $name;
        $this->id = $id;
    }
    
    public function name(){
        return $this->name;
    }
    
    public function id(){
        return $this->id;
    }
    
    public function toArray(){
        return array('id' => $this->id(), 'name' => utf8_encode($this->name()));
    }
    
    public function toJson(){
        return json_encode($this->toArray());
    }
}

?>
