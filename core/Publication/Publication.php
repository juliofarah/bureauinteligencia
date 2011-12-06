<?php
/**
 * Description of Publication
 *
 * @author ramon
 */
abstract class Publication {

    protected $name_table;
    
    protected $id;

    protected $title;

    /**
     *
     * @var SubArea
     */
    protected $subarea;

    /**
     * @var State
     */
    protected $state;
    
    protected $date;    
    
    public function Publication($title, SubArea $subarea = null, State $state = null, $date = null){
        $this->title = $title;;
        $this->subarea = $subarea;
        $this->state = $state;
        $this->date = $date;
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

    public function getSubareaId(){
        return $this->subarea->id();
    }

    public function getSubareaName(){
        return $this->subarea->name();
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
    
    public function date($format = null){
        if($format == null)
            return $this->date;
        return $this->getDateFormatted($format);
    }
    
    public function getDateFormatted($format = "d/m/Y"){
        if($this->date != null){
            return date($format, strtotime($this->date));
        }
        return "";
    }
    
    public function getTableName(){
        return $this->name_table;
    }
       
    public abstract function toArray();

    public function toJSON(){        
        return json_encode($this->toArray());
    }
}
?>
