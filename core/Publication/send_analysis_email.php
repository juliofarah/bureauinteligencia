<?php
    require_once 'util/RequestsPatterns.php';
    $jsonResponse = new JsonResponse();
    if(RequestsPatterns::postParamsSetted('link', 'to', 'name_to') && RequestsPatterns::postParamsSent('link', 'to', 'name_to')){        
        require_once 'core/email/EmailController.php';
        require_once 'PublicationController.php';
        require_once 'PublicationDao.php';
        require_once 'Publication.php';    
        require_once 'Analyse.php';
        require_once 'core/email/Content.php';
        require_once 'core/email/Email.php';

        $emailController = new EmailController();
        $analysisController = new PublicationController(new PublicationDao(Connection::connect()));
        $analysis = $analysisController->getAnAnalysis($_POST['link'], true);        
        if($emailController->setAnalysisEmail($analysis, $_POST['to'], $_POST['name_to'])){
            print_r($jsonResponse->response(true, "Email enviado com sucesso")->serialize());
        }else{
            print_r($jsonResponse->response(false, "Não foi possível enviar o email")->serialize());
        }        
    }else{
        print_r($jsonResponse->response(false, "Alguns campos não foram enviados.")->serialize());
    }
        
?>
