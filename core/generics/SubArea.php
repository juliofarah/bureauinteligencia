<?php
/**
 * Description of SubArea
 *
 * @author ramon
 */
class SubArea {

    private $id;

    private $name;

    public function SubArea($name = null, $id = null){
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
        return array("id"=>$this->id, "name"=> utf8_encode($this->name));
    }

    public function toJson(){
        return json_encode($this->toArray());
    }
}
?>
