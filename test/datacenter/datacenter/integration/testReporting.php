<?php
    require_once 'ReportIntegrationTest.php';
    require_once '../../../../core/DataBase/Connection.php';
    require_once '../../../../core/Datacenter/DatacenterDao.php';
    require_once '../../../../core/Datacenter/DatacenterService.php';
    require_once '../../../../core/Datacenter/Statistic/Statistic.php';
    require_once '../../../../util/JsonResponse.php';
    require_once '../../../../core/Datacenter/DataGrouper.php';
    require_once '../../../../core/Datacenter/BuilderFactory.php';
    require_once '../../../../core/Datacenter/Builder.php';
    require_once '../../../../core/Datacenter/TableBuilder.php';
    require_once '../../../../core/Datacenter/TableJsonBuilder.php';
    require_once '../../../../core/Datacenter/DatacenterController.php';
    require_once '../../../../util/Maps/HashMap.php';
    
    require_once '../../../../core/generics/Param.php';
    require_once '../../../../core/generics/datacenter/Subgroup.php';
    require_once '../../../../core/generics/datacenter/Font.php';
    require_once '../../../../core/generics/datacenter/CoffeType.php';
    require_once '../../../../core/generics/datacenter/Variety.php';
    require_once '../../../../core/generics/datacenter/Country.php';
    require_once '../../../../core/Datacenter/Data.php';    
?>
<?
require_once '../../../../core/Datacenter/ChartBuilder.php';
require_once '../../../../core/Charts/XmlCharts/XmlChart.php';
require_once '../../../../core/Charts/XmlCharts/MultiSerie/XmlMultiSeries.php';
require_once '../../../../core/Charts/XmlCharts/MultiSerie/XmlMultiSeriesCombinationColumnLine.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" lang="pt-br">
    <body>
<?
    $reportIntegration = new ReportIntegrationTest();
    $reportIntegration->integrationTableJson();
    $reportIntegration->integrationChart();
    
    $reportIntegration->emptyTable();
?>  
    </body>
</html>
