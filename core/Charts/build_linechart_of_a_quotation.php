<?php
    require_once 'core/Cotation/CotacoesRefactor/Classifier/DateMap.php';
    require_once 'core/Cotation/CotacoesRefactor/Classifier/Cotation.php';
    require_once 'core/Cotation/CotacoesRefactor/Classifier/Classifier.php';

    require_once 'core/Cotation/CotacoesRefactor/Storage/StorageDao.php';           
    require_once 'core/Cotation/CotacoesRefactor/Storage/StorageController.php';

    require_once 'XmlCharts/XmlChart.php';
    require_once 'XmlCharts/Simple/XmlSimpleSeries.php';    
    
    require_once 'Configs/SimpleSeriesConfig.php';
?>

<?php
    $period = 0;
    
    if(isset ($_GET['period'])){
        if($_GET['period'] == null){
            $period = 6;
        }else{
            $period = $_GET['period'];
        }        
    }else{
        $period = 6;
    }
    
    $quotationCode = $_GET['quotation'];        
    
    $storage = new StorageDao(Connection::connect());
    
    $controller = new StorageController($storage);
    
    $config = new SimpleSeriesConfig();   
    $cotations = $controller->getStorageQuotations($quotationCode, $period);

    if($cotations != null){
        $config->config($cotations);    
        $config->setTitle($quotationCode);
    
        $xml = "arq_line".$quotationCode.".xml";
        $xmlResponse = $config->getChartXml()->buildXml("core/Charts/xml/".$xml);

        $jsonResponse = new JsonResponse();
        print_r($jsonResponse->response(true, null)->addValue("xml", str_replace("\"", "'", $xmlResponse))->serialize());        
    }else{
        $jsonResponse = new JsonResponse();
        print_r($jsonResponse->response(false, "Nenhum valor encontrado neste período")->serialize());
    }

?>
