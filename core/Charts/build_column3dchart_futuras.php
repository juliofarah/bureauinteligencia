<?php
    require_once 'XmlCharts/XmlChart.php';
    require_once 'XmlCharts/MultiSerie/XmlMultiSeries.php';
    require_once 'XmlCharts/MultiSerie/XmlMultiSerieColumn.php';
    require_once 'Configs/MultiSeriesConfig.php';
    require_once 'Configs/MultiSeriesColumnConfig.php';
    require_once 'core/Cotation/CotacoesRefactor/HtmlLib.php';

    $allCots = HtmlLib::cotacoes();

    $config = new MultiSeriesColumnConfig();

    $bmf = $allCots->get("BMF");

    $config->config($bmf);
    $config->config($allCots->get("NY"));
    $config->config($allCots->get("London"));

    $config->configColors();
        
    $xml = "arq_multicolumn.xml";    
    $xmlResponse = $config->getChartXml()->buildXml("core/Charts/xml/".$xml);
        
    $jsonResponse = new JsonResponse();
    print_r($jsonResponse->addValue("xml", str_replace("\"", "'", $xmlResponse))->serialize());
?>
