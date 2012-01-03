<?php

/**
 * Description of WrongTypeException
 *
 * @author Ramon
 */
class WrongTypeException extends RuntimeException{
    
    public function WrongTypeException($msg = null){
        if(is_null($msg)){
            $msg = "Tipo inválido";            
        }
        parent::__construct($msg);
    }
}

?>
