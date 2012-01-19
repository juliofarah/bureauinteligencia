<?php
/**
 * Description of WrongFormatException
 *
 * @author Ramon
 */
class WrongFormatException extends RuntimeException{
    
    public function WrongTypeException($msg = null){
        if($msg == null){
            $msg = "Esta planilha contem um formato inválido de acordo com os padrões definidos.";
        }
        parent::__construct($msg);
    }
}

?>
