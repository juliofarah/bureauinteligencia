<?php
    if(RequestsPatterns::postParamsSetted('email', 'name', 'username', 'password', 'confirm_password', 'city', 'activity')){
        if(RequestsPatterns::postParamsSent('email', 'name', 'username', 'password', 'confirm_password', 'city', 'activity')){
            require_once 'UserController.php';
            require_once 'UserDao.php';
            require_once '../core/generics/City.php';
            require_once '../core/generics/Activity.php';
            
            $city = new City(null, $_POST['city']);
            $activity = new Activity();
            $activity->setId($_POST['activity']);
            
            $user = new User($_POST['name'], $_POST['username'], $_POST['password']);
            $user->setEmail($_POST['email']);
            $user->setCity($city);
            $user->setActivity($activity);
            $positions = 'noticias,metereologia|publicacoes,videoteca|cotacoes';
            $user->setPositions($positions);
            
            $userController = new UserController(new UserDao(Connection::connect()));
            try{
                if($userController->subscribe($user, $_POST['confirm_password'])){
                    $jsonResponse = new JsonResponse();
                    print_r($jsonResponse
                            ->response(true, 'Usuário cadastrado com sucesso. Você será automaticamente conectado ao sistema')
                            ->addValue("redirectTo", LinkController::getBaseURL())
                            ->serialize());                                        
                    Session::login($user);
                    //header('Location: '.LinkController::getBaseURL());
                }else{
                    $jsonResponse = new JsonResponse();
                    print_r($jsonResponse->response(false, 'Falha no cadastro do usuário. Favor tentar novamente')->serialize());                    
                }
            }catch(Exception $err){
                $jsonResponse = new JsonResponse();
                print_r($jsonResponse->response(false, $err->getMessage())->serialize());                
            }
        }else{
            $jsonResponse = new JsonResponse();
            print_r($jsonResponse->response(false, 'Parâmetros não podem estar vazios')->serialize());
        }
    }else{
        $jsonResponse = new JsonResponse();
        print_r($jsonResponse->response(false, 'Parâmetros não configurados. Comunique o desenvovledor.')->serialize());
    }

?>
