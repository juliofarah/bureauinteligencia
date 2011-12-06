<?php
/**
 * Description of Area
 *
 * @author ramon
 */
class Area {

    private $id;

    private $name;

    public function Area($name, $id = null){
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
        return array('id' => $this->id, 'name' => utf8_encode($this->name));
    }

    public function toJson(){
        return json_encode($this->toArray());
    }
}
?>
