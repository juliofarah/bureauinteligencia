<?php   
error_reporting(E_ALL);
ini_set('display_errors', '1');
    if(RequestsPatterns::postParamsSetted(RequestsPatterns::$LINK, RequestsPatterns::$TITLE, 'subarea', 'duration', 'type_event')){
        if(RequestsPatterns::postParamsSent(RequestsPatterns::$LINK, RequestsPatterns::$TITLE, 'subarea', 'duration', 'type_event')){
            require_once "VideoController.php";
            require_once "VideoDao.php";
            require_once "Video.php";                        
            require_once "SubArea.php";
            require_once "../core/generics/State.php";
            
            $controller = new VideoController(new VideoDao(Connection::connect()));
            try{
                $subarea = new SubArea(null, $_POST['subarea']);
                //$state = new State($_POST['state'], null, null);
                $videoLink = $controller->turnLinkToId($_POST[RequestsPatterns::$LINK]);                
                $video = new Video($_POST[RequestsPatterns::$TITLE], $videoLink, date("Y-m-d"), $subarea, null, $_POST['type_event'], $_POST['duration']);

                $controller->save($video);
                $jsonResponse = new JsonResponse();
                print_r($jsonResponse->response(TRUE, "Video inserido com sucesso!")->serialize());
            }catch(PDOException $err){
                $jsonResponse = new JsonResponse();
                print_r($jsonResponse->response(FALSE, $err->getMessage())->serialize());
            }catch(Exception $err){
                $jsonResponse = new JsonResponse();
                print_r($jsonResponse->response(NULL, $err->getMessage())->serialize());
            }
        }else{
            $jsonResponse = new JsonResponse();
            print_r($jsonResponse->response(NULL, "Todos os campos devem ser preenchidos!")->serialize());
        }
    }else{
        $jsonResponse = new JsonResponse();
        print_r($jsonResponse->response(FALSE, "Os parâmetros não foram configurados. Comunique o desenvolvedor.")->serialize());
    }
?>
