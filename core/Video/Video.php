<?php
/**
 * Description of Video
 *
 * @author RAMONox
 */
class Video {

    private $id;

    private $title;

    private $link;

    private $date;

    /**
     * @var SubArea
     */
    private $subArea;
    
    /**    
     * @var State 
     */
    private $state;
    
    private $duration;
    
    private $event;
    
    public function Video($title, $link, $date, SubArea $subArea = null, State $state = null, $event = null, $duration = null){
        $this->title = $title;
        $this->link = $link;
        $this->date = $date;
        $this->subArea = $subArea;
        $this->state = $state;
        $this->event = $event;
        $this->duration = $duration;
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

    public function date(){
        return $this->date;
    }

    public function idSubArea(){
        return $this->subArea->id();
    }

    public function nameSubArea(){
        return $this->subArea->name();
    }

    public function getStateUF(){
        return $this->state->UF();
    }

    public function getStateName(){
        return $this->state->name();
    }

    public function getStateId(){
        return $this->state->id();
    }
    
    public function getEvent(){
        return $this->event;
    }
    
    public function getDuration(){
        return $this->duration;
    }
    
    public function toArray(){
        $array = array('title' => $this->title(), 'link' => $this->link(), 'date' => $this->date());
        if($this->subArea != null)
            $array['subarea'] = $this->subArea->toArray();
        if($this->state != null)
            $array['state'] = $this->state->toArray();
        if($this->event != null)
            $array['event'] = $this->getEvent();
        if($this->duration != null)
            $array['duration'] = $this->getDuration();
        return $array;
    }

    public function toJSON(){
        return json_encode($this->toArray());
    }
}
?>
