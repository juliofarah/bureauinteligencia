<?php    
$jsonResponse = new JsonResponse();
    $_POST['fromAdmin'] = true;    
    require_once 'build.php';
if(RequestsPatterns::postParamsSetted('subgroup', 'font', 'coffetype', 'variety', 'destiny')){
    if(RequestsPatterns::postParamsSent('subgroup', 'font', 'coffetype', 'variety', 'destiny')){
        require_once '../core/Exceptions/WrongTypeException.php';
        require_once '../core/Exceptions/WrongFormatException.php';
        require_once '../core/Datacenter/CountryMap.php';
        require_once '../util/excel/reader/ExcelInputFile.php';
        require_once '../util/excel/reader/SpreadsheetValidator.php';
        require_once '../util/excel/reader/excel_reader2.php';
        
        $file = $_FILES['Planilha']['tmp_name'];
        
        $subgroup = $_POST['subgroup'];
        $font = $_POST['font'];
        $coffeType = $_POST['coffetype'];
        $variety = $_POST['variety'];
        $destiny = $_POST['destiny'];
                
        $repository = new DatacenterDao(Connection::connectToTest());        
        $service = new DatacenterService($repository, new CountryMap());
        $statistic = new Statistic();
        $jsonResponse = new JsonResponse();
        $grouper = new DataGrouper();
        $factory = new BuilderFactory();        
        $controller = new DatacenterController($service, $statistic, $jsonResponse, $grouper, $factory); 
        
        $reader = new Spreadsheet_Excel_Reader($_FILES['Planilha']['tmp_name']);        
        try{
            $inputFile = new ExcelInputFile($reader);            
            $response = $controller->saveValues($inputFile, $subgroup, $font, $destiny, $coffeType, $variety);
            //print_r($jsonResponse->response(false, "buceta vila")->withoutHeader()->serialize());
            print_r($response);
        }catch(WrongFormatException $exception){
            print_r($jsonResponse->response(false, $exception->getMessage())->withoutHeader()->serialize());
        }catch(Exception $exception){
            print_r($jsonResponse->response(false, $exception->getMessage())->withoutHeader()->serialize());
        }
    }else{
        print_r($jsonResponse->response(false, "Todos os campos devem ser preenchidos e/ou marcados.")->withoutHeader()->serialize());
    }
}else{
    print_r($jsonResponse->response(false, "Parâmetros não configurados corretamente.")->withoutHeader()->serialize());    
}
?>
