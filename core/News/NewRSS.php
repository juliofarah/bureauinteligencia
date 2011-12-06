<?php
class NewRSS {

    private $id;

    private $title;

    private $link;
    
    private $position;

    public function NewRSS($title, $link, $position = null){
        $this->title = $title;
        $this->link = $link;
        $this->position = $position;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function id(){
        return $this->id;
    }
    
    public function title(){
        return $this->title;
    }

    public function link(){
        return $this->link;
    }
    
    public function position(){
        return $this->position;
    }
}
?>
