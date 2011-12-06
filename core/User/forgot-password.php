<?php
    require_once 'util/RequestsPatterns.php';
    if(RequestsPatterns::postParamsSetted('username', 'email')){
        if(RequestsPatterns::postParamsSent('username', 'email')){
            require_once 'UserController.php';
            require_once 'UserDao.php';
            require_once 'core/email/Content.php';
            require_once 'core/email/Email.php';
            require_once 'core/email/EmailController.php';
            $userController = new UserController(new UserDao(Connection::connect()));
            $jsonResponse = new JsonResponse();
            try{
                $user = new User(null, $_POST['username']);                
                $user->setEmail($_POST['email']);
                if($userController->newPassword($user)){
                    print_r($jsonResponse->response(true, "Um email foi enviado para você com sua nova senha!")->serialize());
                }else{
                    print_r($jsonResponse->response(true, "Falha ao gerar nova senha!")->serialize());
                }
            }catch(Exception $err){
                print_r($jsonResponse->response(false, $err->getMessage())->serialize());
            }
        }else{
            $jsonResponse = new JsonResponse();
            print_r($jsonResponse->response(false, "Os campos não podem estar vazios")->serialize());
        }
    }else{
        $jsonResponse = new JsonResponse();
        print_r($jsonResponse->response(false, "Parâmetros não configurados")->serialize());
    }
?>
