<?php

/**
 * Description of State
 *
 * @author ramon
 */
class State {

    private $id;

    private $uf;

    private $name;

    public function State($id, $uf = null, $name = null){
        $this->id = $id;
        $this->uf = $uf;
        $this->name = $name;
    }

    public function id(){
        return $this->id;
    }

    public function UF(){
        return $this->uf;
    }

    public function name(){
        return utf8_encode($this->name);
    }

    public function toArray(){
        return array('id' => $this->id(), 'UF' => $this->UF(), 'name' => $this->name());
    }

    public function toJson(){
        return json_encode($this->toArray());
    }
}
?>
