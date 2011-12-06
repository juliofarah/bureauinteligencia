<?php
/**
 * Description of Analyse
 *
 * @author ramon
 */
class Analyse extends Publication{
    
    private $link; 
    
    private $text;        
    
    /**     
     * @var ArrayObject 
     */
    private $comments;
    
    public function Analyse($title, Subarea $subarea = null, State $state = null, $date = null){
        $this->name_table = "analysis";
        parent::Publication($title, $subarea, $state, $date);
        $this->comments = new ArrayObject();
        $this->setLink(StringManager::removeSpecialChars($title));         
    }

    public function setLink($link){
        $this->link = str_replace(" ", "-", $link);
    }
    
    public function link(){
        return $this->link;
    }
    
    public function setText($text){
        $this->text = $text;
    }
    
    public function text(){
        return $this->text;
    }
    
    public function loadComments(ArrayObject $comments){
        $this->comments = $comments;
    }
    
    public function addComment(Comment $comment){
        $comment->setAnalyse($this);
        $this->comments->append($comment);
    }

    public function getComments(){
        return $this->comments;
    }
    
    public function toArray(){
        $array = array('title' => $this->title, 'link' => $this->link);        
        if($this->subarea != null)
            $array['subarea'] = $this->subarea->toArray();
        if($this->state != null)
            $array['state'] = $this->state->toArray();
        if($this->date() != null)
            $array['date'] = $this->date("d/m/Y");
        return $array;
    }    
}

?>
