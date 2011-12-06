<?php
/**
 * Description of Paper
 *
 * @author ramon
 */
class Paper extends Publication{

    /**     
     * @var File 
     */
    private $file;

    private $event;

    /**     
     * @var PublicationType
     */
    private $type;
    
    private $year;
    
    public function Paper($title, SubArea $subarea = null, File $file = null, State $state = null, $date = null, $event = null, PublicationType $type = null, $year = null){
        $this->name_table = "paper";        
        parent::Publication($title, $subarea, $state, $date);                   
        $this->file = $file;
        $this->event = $event;
        $this->type = $type;
        $this->year = $year;
    }

    public function getFilename(){
        return $this->file->name();
    }

    public function getSimpleFilename(){
        return $this->file->getName();
    }
    
    public function getFiletype(){
        return $this->file->getType();
    }

    public function saveFile($dir){
        return $this->file->save($dir);
    }
    
    public function getEvent(){
        return $this->event;
    }
    
    public function getTypename(){
        return $this->type->name();
    }
    
    public function getTypeId(){
        return $this->type->id();
    }
    
    public function getYear(){
        return $this->year;
    }
    
    public function toArray(){
        $array = array('title' => $this->title);
        if($this->subarea != null)
            $array['subarea'] = $this->subarea->toArray();
        if($this->file != null)
            $array['file'] = $this->file->toArray();
        if($this->state != null)
            $array['state'] = $this->state->toArray();
        if($this->date != null)
            $array['date'] = $this->date ();
        if($this->type != null)
            $array['type'] = $this->getType();
        if($this->year != null)
            $array['year'] = $this->getYear ();
        if($this->event != null)
            $array['event'] = $this->getEvent ();
        return $array;
    }
}
?>
