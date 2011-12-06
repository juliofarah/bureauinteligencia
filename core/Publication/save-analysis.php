<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$jsonResponse = new JsonResponse();
if(RequestsPatterns::postParamsSetted(RequestsPatterns::$TITLE, 'subarea', 'state', 'text')){
    if(RequestsPatterns::postParamsSent(RequestsPatterns::$TITLE, 'subarea', 'state', 'text')){
        require_once 'PublicationController.php';
        require_once 'Publication.php';    
        require_once 'Analyse.php';
        require_once 'PublicationDao.php';
        require_once '../core/generics/SubArea.php';
        require_once '../core/generics/State.php';
        $controller = new PublicationController(new PublicationDao(Connection::connect()));
        $publication = new Analyse($_POST[RequestsPatterns::$TITLE], new SubArea(null, $_POST['subarea']), new State($_POST['state']), date("Y-m-d"));        
        $publication->setText($_POST['text']);
        try{
            $controller->saveAnalysis($publication);
            print_r($jsonResponse->response(true, "Análise inserida com sucesso!")->serialize());
        }catch(Exception $err){
            print_r($jsonResponse->response(false, $err->getMessage())->serialize());
        }        
    }else{
        print_r($jsonResponse->response(false, "Todos os campos devem ser preenchidos.")->serialize());
    }
}else{
    print_r($jsonResponse->response(false, "Alguns parâmetros não foram configurados")->serialize());    
}
?>
