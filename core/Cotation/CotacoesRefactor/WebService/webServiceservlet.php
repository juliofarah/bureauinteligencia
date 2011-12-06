<?php
    $json = $_REQUEST['info'];

    require_once 'WebService.php';

    $webService = new WebService();
    echo "Dados recebidos\n";    
    $webService->setJson($json);
    $webService->editArqJson();   
        
    $toStop = mktime(15, 05, 0); 
    
    $now = mktime();            
    
    $diff = $toStop - $now;
    
    echo ($diff > 0);
   
    if($diff > 0){
        include_once '../Storage/do-storage.php';
    }else{
		echo "\nO periodo de operacao ja foi finalizado. Hoje os dados não serao mais armazenados";
	}

?>
