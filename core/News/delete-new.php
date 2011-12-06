<?php
    $jsonResponse = new JsonResponse();
    if(RequestsPatterns::postParamsSetted(RequestsPatterns::$ID)){
        if(RequestsPatterns::postParamsSent(RequestsPatterns::$ID)){
            require_once 'NewsController.php';
            require_once 'NewsDao.php';
            $controller = new NewsController(new NewsDao(Connection::connect()));
            try{
                if($controller->delete($_POST[RequestsPatterns::$ID])){
                    print_r($jsonResponse->response(true, "Feed excluído com sucesso!")->serialize());
                }else{
                    print_r($jsonResponse->response(false, "Falha ao excluir feed!")->serialize());
                }
            }catch(Exception $err){
                print_r($jsonResponse->response(false, $err->getMessage())->serialize());
            }
        }else{
            print_r($jsonResponse->response(false, "O identificador da notícia não pode estar vazio!")->serialize());
        }
    }else{
        print_r($jsonResponse->response(false, "Parâmetros não enviados")->serialize());
    }
?>
