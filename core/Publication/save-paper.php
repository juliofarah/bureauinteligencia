<?php
$jsonResponse = new JsonResponse();
if(RequestsPatterns::postParamsSetted(RequestsPatterns::$TITLE, 'subarea', 'year', 'publication_type')){    
    if(RequestsPatterns::postParamsSent(RequestsPatterns::$TITLE, 'subarea', 'year', 'publication_type')){
        
        require_once 'File.php';
        require_once 'PublicationController.php';       
        require_once 'Publication.php';    
        require_once 'Paper.php';
        require_once 'PublicationDao.php';
        require_once '../core/generics/SubArea.php';
        //require_once '../core/generics/State.php';
        require_once '../core/generics/PublicationType.php';
        
        //$jsonResponse = new JsonResponse();

        $file = $_FILES['Arquivo'];

        $controller = new PublicationController(new PublicationDao(Connection::connect()));

        $controller->setPath("../publicacao/");
        
        $publicationType = new PublicationType(null, $_POST['publication_type']);
                
        $publication = new Paper($_POST['title'], new SubArea(null, $_POST['subarea']), new File($file), null/*new State($_POST['state'])*/, date("Y-m-d"), /*$_POST['type_event']*/null, $publicationType, $_POST['year']);                
                
        //print_r($jsonResponse->response(false, $publication->getTypeId())->withoutHeader()->serialize());
        try{                        
            $controller->savePaper($publication);
            print_r($jsonResponse->response(true, "Arquivo enviado com sucesso!")->withoutHeader()->serialize());
        }catch(Exception $err){
            print_r($jsonResponse->response(false, $err->getMessage())->withoutHeader()->serialize());
        }
    }else{
        //print_r($jsonResponse->response(false, "Arquivo enviado com sucesso PORRA NENHUMA!".$_POST['publication_type'])->withoutHeader()->serialize());
        print_r($jsonResponse->response(false, "Todos os campos devem ser preenchidos e/ou marcados.")->withoutHeader()->serialize());
    }
}else{
    print_r($jsonResponse->response(false, "Parâmetros não configurados corretamente.")->withoutHeader()->serialize());    
}

?>
