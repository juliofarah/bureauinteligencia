<?php
    $jsonResponse = new JsonResponse();
    if(RequestsPatterns::postParamsSetted(RequestsPatterns::$TITLE, RequestsPatterns::$LINK)){
        if(RequestsPatterns::postParamsSent(RequestsPatterns::$TITLE, RequestsPatterns::$LINK)){
            require_once 'NewsController.php';
            require_once 'NewsDao.php';
            require_once 'NewRSS.php';
            try{
                $controller = new NewsController(new NewsDao(Connection::connect()));
                $controller->save(new NewRSS($_POST[RequestsPatterns::$TITLE], $_POST[RequestsPatterns::$LINK]));
                print_r($jsonResponse->response(TRUE, "RSS inserido com sucesso!")->serialize());
            }catch(PDOException $err){
                print_r($jsonResponse->response(FALSE, $err->getMessage())->serialize());
            }catch(LoginException $err){
                print_r($jsonResponse->response(NULL, $err->getMessage())->serialize());
            }
        }else{
            print_r($jsonResponse->response(NULL, "Todos os campos devem ser preenchidos.")->serialize());
        }
    }else{
        
        print_r($jsonResponse->response(FALSE, "Os parâmetros não foram configurados. Comunique o desenvolvedor")->serialize());
    }
?>
