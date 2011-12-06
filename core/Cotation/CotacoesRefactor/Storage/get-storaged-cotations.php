<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once 'core/Cotation/CotacoesRefactor/Classifier/DateMap.php';
    require_once 'core/Cotation/CotacoesRefactor/Classifier/Cotation.php';
    require_once 'core/Cotation/CotacoesRefactor/Classifier/Classifier.php';

    require_once 'StorageDao.php';           
    require_once 'StorageController.php';
    
    require_once 'core/Charts/XmlCharts/XmlChart.php';
    require_once 'core/Charts/XmlCharts/Simple/XmlSimpleSeries.php';    
    
    require_once 'core/Charts/Configs/SimpleSeriesConfig.php';
    
?>

<?php    

    $quotationCode = $_GET['quotation'];        
    
    $storage = new StorageDao(Connection::connect());
    
    $controller = new StorageController($storage);
    
    header('Content-type: application/json');
    echo $controller->getStorageQuotationsToJson($quotationCode);       
?>
