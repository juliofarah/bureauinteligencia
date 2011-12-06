<?php
/**
 * Description of LoginException
 *
 * @author RAMONox
 */
class LoginException extends RuntimeException{
    public function LoginException($message = ''){
        if($message != null)
            parent::__construct($message);
        else
            parent::__construct("Você deve fazer Login para acessar o sistema");
    }

    public function redirect(){
        header("Location: ".LinkController::getBaseURL());
    }

    public function loginPage(){
        return "loginer.php";
    }
}
?>
