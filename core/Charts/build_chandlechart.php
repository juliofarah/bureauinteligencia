<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
    require_once 'core/Cotation/CotacoesRefactor/Classifier/DateMap.php';
    require_once 'core/Cotation/CotacoesRefactor/Classifier/Cotation.php';
    require_once 'core/Cotation/CotacoesRefactor/Classifier/Classifier.php';


    require_once 'core/Cotation/CotacoesRefactor/Storage/StorageDao.php';           
    require_once 'core/Cotation/CotacoesRefactor/Storage/StorageController.php';

    require_once 'XmlCharts/XmlChart.php';
    require_once 'XmlCharts/MultiSerie/XmlMultiSeries.php';
    require_once 'Configs/MultiSeriesConfig.php';
    require_once 'Configs/MultiSeriesCandleConfig.php';
    require_once 'Configs/MultiSeriesColumnConfig.php';
    require_once 'XmlCharts/MultiSerie/XMLMultiSeriesCandle.php';
    require_once 'XmlCharts/MultiSerie/XmlMultiSerieColumn.php';    
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
    $config = new MultiSeriesCandleConfig();
    $cotations = $controller->getStorageQuotations($quotationCode, $period);
    
    if($cotations != null && $cotations->count() > 0){
        $config->config($cotations);
        $config->addChartAttribute('vnumberScaleValue', '1000');
        $config->addChartAttribute('formatNumber', '1');
        $config->addChartAttribute('formatNumberScale', '1');
        $config->addChartAttribute('numberScaleValue', '1000');
        $config->addChartAttribute('PYAxisName', 'Valor');
        $config->addChartAttribute('plotPriceAs', 'candlestick');
        $xml = "arq_chandle.xml";    
        $xmlResponse = $config->getChartXml()->buildXml("core/Charts/xml/".$xml);        

        $jsonResponse = new JsonResponse();
        print_r($jsonResponse->response(true, null)->addValue("futura", true)->addValue("xml", str_replace("\"", "'", $xmlResponse))->serialize());        
        
    }else{
        $jsonResponse = new JsonResponse();
        print_r($jsonResponse->response(false, "Nenhum valor encontrado neste período")->serialize());        
    }    
?>
