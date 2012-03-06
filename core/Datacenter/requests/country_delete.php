<?php
    require_once '../core/generics/Controller.php';
    require_once '../core/generics/GenericDao.php';        
    
    $json = new JsonResponse();    
    print_r($json->response(false, "Ainda não é possível realizar exclusão de países.")->serialize());  
?>
