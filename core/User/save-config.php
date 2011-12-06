<?php    
    require_once 'UserDao.php';
    require_once 'User.php';
    $user = new User(Session::getLoggedUser()->name(), Session::getLoggedUser()->username());
    $user->setPositions($_POST['apps-position']);

    $userdao = new UserDao(Connection::connect());
    $jsonResponse = new JsonResponse();
    if($userdao->saveConfig($user)){        
        print_r($jsonResponse->response(true, "Suas configurações foram armazenadas com suceso!")->serialize());
    }else{
        print_r($jsonResponse->response(false, "Falha ao salvar configurações do perfil")->serialize());
    }

?>
