<?php
    require_once 'util/RequestsPatterns.php';
    $jsonResponse = new JsonResponse();
    if(RequestsPatterns::postParamsSetted('title', 'text', 'analysis_id')){
        if(RequestsPatterns::postParamsSent('title', 'text', 'analysis_id')){
            if(Session::isLogged()){
                require_once 'core/User/User.php';
                require_once 'Publication.php';                
                require_once 'Analyse.php';                        
                require_once 'PublicationController.php';
                require_once 'PublicationDao.php';
                require_once 'Comment.php';
                
                
                $user = Session::getLoggedUser();
                $analysis = new Analyse(null);
                $analysis->setId($_POST['analysis_id']);
                $user->comment(new Comment(date("Y-m-d H:i:s"), $_POST['title'], $_POST['text']), $analysis);
                $controller = new PublicationController(new PublicationDao(Connection::connect()));
                try{
                    if($controller->comment($analysis)){
                        print_r($jsonResponse->response(true, "Comentário enviado com sucesso!")->serialize());
                    }else{
                        print_r($jsonResponse->response(false, "Falha ao eviar comentário. Tente novamente")->serialize());
                    }                       
                }catch(Exception $err){
                    print_r($jsonResponse->response(false, $err->getMessage())->serialize());
                }             
            }else{
                print_r($jsonResponse->response(false, "Faça o login para poder deixar seu comentário")->serialize());
            }
        }else{
            print_r($jsonResponse->response(false, "Os campos não podem estar vazios")->serialize());
        }
    }else{
        print_r($jsonResponse->response(false, "Parâmetros de envio não foram configurados")->serialize());
    }
?>
