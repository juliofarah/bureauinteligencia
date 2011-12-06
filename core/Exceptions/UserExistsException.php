<?php

/**
 * Description of UserExistsException
 *
 * @author ramon
 */
class UserExistsException extends RuntimeException {

    public function UserExistsException(){
        parent::__construct("Login de usuário já foi utilizado!");
    }

}
?>
