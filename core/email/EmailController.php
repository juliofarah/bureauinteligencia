<?php

/**
 * Description of EmailController
 *
 * @author ramon
 */
class EmailController {
        
    public function EmailController(){
        
    }
    
    public function sendNewPasswordEmail(User $user, $newPassword){
        $content = new Content();        
        $message = str_replace(
                        array(":name", ":pass"), 
                        array($user->name(), $newPassword), 
                        $content->getContentNewPassword());
        $email = new Email();
        $email->setSubject("Nova senha - Bureau Inteligência");        
        $email->setMessage($message);
        return $email->send($user);
    }        
    
    public function setAnalysisEmail(Analyse $analysis, $emailTo, $toName){
        $content = new Content();
        $message = $content->getAnalysisContent($analysis, Session::getLoggedUser()->getFirstName());
        $email = new Email();
        $email->setSubject("Olá ".$toName."! Você recebeu uma análise do Bureau Inteligencia!");
        $email->setMessage($message);        
        
        return $email->send(null, $emailTo);
    }
}

?>
