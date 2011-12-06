<?php

/**
 * Description of Email
 *
 * @author ramon
 */
class Email {
    
    private $subject;
    
    private $remetente = "agrocim@agrocim.com.br";
    
    private $message;
        
    public function Email(){
    }
    
    public function setSubject($subject){
        $this->subject = $subject;
    }        
                
    private function getParameters(){                
        $headers = "MIME-Version: 1.0 \r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Bureau Inteligência <'.$this->remetente.'>' . "\r\n";
        //$headers .= 'Reply-To: '.$this->remetente;        
        return $headers;
    }

    public function setMessage($message){
        $this->message = $message;
    }
    
    public function send(User $user = null, $email = null){
        if($user != null)
            return mail($user->email(), $this->subject, $this->message, $this->getParameters());//"From: Bureau Inteligência <agrocim@agrocim.com.br>");
        elseif($email != null)
            return mail($email, $this->subject, $this->message, $this->getParameters());
        else
            return false;
    }
       
}

?>
