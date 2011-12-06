<?php
    $jsonResponse = new JsonResponse();
    if(RequestsPatterns::postParamsSetted(RequestsPatterns::$ID)){
        if(RequestsPatterns::postParamsSent(RequestsPatterns::$ID)){
            require_once 'VideoController.php';
            require_once 'VideoDao.php';
            $controller = new VideoController(new VideoDao(Connection::connect()));

            try{
                if($controller->delete($_POST[RequestsPatterns::$ID])){
                    print_r($jsonResponse->response(true, "Video excluído com sucesso")->serialize());
                }else{
                    print_r($jsonResponse->response(false, "Falha ao excluir o video")->serialize());
                }
            }catch(Exception $err){
                print_r($jsonResponse->response(false, $err->getMessage())->serialize());
            }
        }else{
            print_r($jsonResponse->response(false, "O identificador do video não pode estar vazio!")->serialize());
        }
    }else{
        print_r($jsonResponse->response(false, "Parâmetros não configurados!")->serialize());
    }
?>
