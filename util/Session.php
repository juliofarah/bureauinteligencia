<?php
/**
 * Description of Session
 *
 * @author Vista
 */
class Session {
    private static $USER_SESSION = 'bureau_user_session'; 

    private static function initSession(){
        $id_randon = rand(0,10000);
        self::$USER_SESSION.= $id_randon;
    }

    public static function getAdminName(){
        return unserialize($_SESSION[self::$USER_SESSION])->name();
    }

    public static function getAdminUsername(){
        return unserialize($_SESSION[self::$USER_SESSION])->username();
    }

    public static function isLogged(){        
        return !empty($_SESSION[self::$USER_SESSION]);
    }

    public static function login(User $user){
        //self::initSession();
        $_SESSION[self::$USER_SESSION] = serialize($user);
    }

    public static function logout(){        
        $_SESSION[self::$USER_SESSION] = null;
    }
    /**
     * @return User
     */
    public static function getLoggedUser(){                        
        return Session::isLogged() ? unserialize($_SESSION[self::$USER_SESSION]) : null;
    }
}
?>
