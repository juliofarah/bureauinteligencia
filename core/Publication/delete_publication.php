<?php    
    $jsonResponse = new JsonResponse();   
    if(RequestsPatterns::postParamsSetted('id', 'type')){
        if(RequestsPatterns::postParamsSent('id', 'type')){
            require_once 'PublicationController.php';
            require_once 'PublicationDao.php';
            require_once 'Publication.php';
            $controller = new PublicationController(new PublicationDao(Connection::connect()));
            if($_POST['type'] == 'analysis'){
                require_once 'Analyse.php';
                $publication = new Analyse(null);                
            }elseif($_POST['type'] == 'paper'){
                require_once 'Paper.php';
                $publication = new Paper(null);
            }
            $publication->setId($_POST['id']);            
            try{
                if($controller->delete($publication)){
                    print_r($jsonResponse->response(true, "Publicação excluída com sucesso")->serialize());
                }else{
                    print_r($jsonResponse->response(false, "Falha ao excluir a publicação.")->serialize());
                }                
            }catch(Exception $err){
                print_r($jsonResponse->response(false, $err->getMessage())->serialize());
            }
        }else{
            print_r($jsonResponse->response(false, "Os parâmetros não podem estar vazios")->serialize());
        }
    }else{
        print_r($jsonResponse->response(false, "Parâmetros não configurados")->serialize());
    }
?>

