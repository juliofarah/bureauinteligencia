<?php

require_once 'AdminLoginDao.php';

class AdminLogin {

    /**
     * @var AdminLoginDao
     */
    private $dao;

    public function AdminLogin(AdminLoginDao $dao = null){
        $this->dao = $dao;
    }

    public function login(AdminUser $admin){
        $admin = $this->dao->getToLogin($admin);
        if($admin != null){
            $admin->login();
            return true;
        }
        return false;
    }

    public function logout(AdminUser $admin){        
        $admin->logout();
        header("Location: ".LinkController::getBaseURL()."/admin");
    }
}
?>
