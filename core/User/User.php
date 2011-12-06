<?php
class User {
    private $name;

    private $username;

    private $password;

    private $positions;        
    
    private $email;
    
    /**     
     * @var City 
     */
    private $city;
    
    /**    
     * @var Activity 
     */
    private $activity;

    public function User($name, $username, $password = null){
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    public function setEmail($email){
        $this->email = $email;
    }
    
    public function email(){
        return $this->email;
    }
    
    public function name(){
        return trim($this->name);
    }
    
    public function getFirstName(){
        return substr($this->name(), 0, strpos($this->name(), " "));
    }

    public function username(){
        return $this->username;
    }

    public function password(){
        return $this->password;
    }

    public function setPositions($positions){
        $this->positions = $positions;
    }

    public function getPositions(){
        return $this->positions;
    }
    
    public function setCity(City $city){
        $this->city = $city;
    }
    
    public function getCityId(){
        return $this->city->id();
    }
    
    public function getCityName(){
        return $this->city->name();
    }
        
    public function setActivity(Activity $activity){
        $this->activity = $activity;
    }
    
    public function getMyActivityId(){
        return $this->activity->id();
    }
    
    public function getMyActivityName(){
        return $this->activity->name();
    }
    
    public function comment(Comment $comment, Analyse $analysis){
        $comment->setUser($this);
        $analysis->addComment($comment);
    }
}
?>
