<?
    require_once '../core/generics/Param.php';
    require_once '../core/generics/datacenter/Country.php';
    require_once '../core/generics/Controller.php';
    require_once '../core/generics/GenericDao.php';        
    
    $json = new JsonResponse();
    
    if(RequestsPatterns::postParamsSetted('name', 'type')){
        if(RequestsPatterns::postParamsSent('name', 'type')){
            $name = $_POST['name'];
            $typeCountry = $_POST['type'];
            
            $country = new Country($name);
             
            $dao = new GenericDao(Connection::connect());
            $controller = new Controller($dao);
            
            $message = "País inserido com sucesso";
            $message_error = "Falha na inserção do país"; 
            try{
                if($typeCountry == 'origin'){
                    if($controller->createNewOriginCountry($country))
                        print_r($json->response (true, $message)->serialize ());
                    else
                        print_r($json->response (true, $message_error)->serialize ());
                }else{
                    if($controller->createNewDestinyCountry($country))
                        print_r($json->response (true, $message)->serialize ());
                    else
                        print_r($json->response (true, $message_error)->serialize ());
                }                
            }catch(Exception $err){
                print_r($json->response(false, $err->getMessage())->serialize());
            }
        }else{
            print_r($json->response(false, "Os campos não podem estar vazios.")->serialize());
        }
    }else{
        print_r($json->response(false, "Parâmetros não configurados. Comunique o desenvolvedor")->serialize());
    }    
?>
