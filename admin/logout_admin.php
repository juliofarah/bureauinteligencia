<?
    require_once 'AdminLogin.php';

    $loginController = new AdminLogin();
    $loginController->logout(SessionAdmin::getLoggedUser());
   
?>