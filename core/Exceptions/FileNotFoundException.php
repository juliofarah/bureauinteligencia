<?php
/**
 * Description of FileNotFoundException
 *
 * @author Vista
 */
class FileNotFoundException extends RuntimeException{

    public function FileNotFoundException($message = ''){
        if($message == ''){
            parent::__construct("Arquivo não encontrado!");
        }else{
            parent::__construct($message);
        }
    }
}
?>
