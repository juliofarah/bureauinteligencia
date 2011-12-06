<?php
    require_once 'File.php';
    require_once 'PublicationController.php';
    require_once 'Publication.php';    
    require_once 'PublicationDao.php';
    require_once '../core/generics/SubArea.php';
    require_once '../core/generics/State.php';
    $jsonResponse = new JsonResponse();
    
    $file = $_FILES['Arquivo'];
    
    $controller = new PublicationController(new PublicationDao(Connection::connect()));

    $controller->setPath("../publicacao/");

    $publication = new Publication($_POST['title'], new SubArea(null, $_POST['subarea']), new File($file), new State($_POST['state']), null, null);

    try{
        $controller->save($publication);
        print_r($jsonResponse->response(true, "Arquivo enviado com sucesso!")->withoutHeader()->serialize());
    }catch(Exception $err){
        print_r($jsonResponse->response(false, $err->getMessage())->withoutHeader()->serialize());
    }

?>
