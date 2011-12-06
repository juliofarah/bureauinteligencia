<?php


/**
 * Description of Comment
 *
 * @author ramon
 */
class Comment {
    
    private $datetime;
    
    private $title;
    
    private $text;
    
    /**     
     * @var User 
     */
    private $writter;
    
    /**     
     * @var Analyse 
     */
    private $analysis;
    
    public function Comment($datetime, $title, $text){
        $this->datetime = $datetime;
        $this->title = $title;
        $this->text = $text;
    }
    
    public function setUser(User $user){
        $this->writter = $user;
    }
    
    /**     
     * @return User 
     */
    public function getWitter(){
        return $this->writter;
    }
    
    public function getWritterUsername(){
        return $this->writter->username();
    }
    
    public function setAnalyse(Analyse $analysis){
        $this->analysis = $analysis;
    }
    
    public function getAnalysisId(){
        return $this->analysis->id();
    }
    
    public function dateTime(){
        return $this->datetime;
    }
    
    public function getFormatedDatetime(){
        return date("d/m/Y - H:i:s", strtotime($this->dateTime()));
    }    
        
    public function title(){
        return $this->title;
    }
    
    public function text(){
        return $this->text;
    }
        
}

?>
