<?php
    if(!empty($_POST['username'])){
        require_once 'AdminUser.php';
        require_once 'AdminLogin.php';
        echo 'Im here';
        $adminLogin = new AdminLogin(new AdminLoginDao(Connection::connectLogin()));
        if($adminLogin->login(new AdminUser($_POST['username'], null, $_POST['password']))){
            header("Location: ".LinkController::getBaseURL()."/admin");
        }else{
            header("Location: ".LinkController::getBaseURL()."/admin/login-fail");
        }
    }else{        
        header("Location: ".LinkController::getBaseURL()."/admin/login-fail/empty");
    }
?>
