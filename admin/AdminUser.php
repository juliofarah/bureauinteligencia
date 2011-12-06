<?php
/**
 * Description of AdminUser
 *
 * @author ramon
 */
class AdminUser {

    private $username;

    private $name;

    private $password;

    private $id;

    public function AdminUser($username, $name, $password = null, $id = null){
        $this->username = $username;
        $this->name = $name;
        $this->password = $password;
        $this->id = $id;
    }

    public function name(){
        return $this->name;
    }

    public function username(){
        return $this->username;
    }

    public function password(){
        return $this->password;
    }

    public function id(){
        return $this->id;
    }

    public function login(){        
        SessionAdmin::login($this);
    }

    public function logout(){
        SessionAdmin::logout();
    }
}
?>
