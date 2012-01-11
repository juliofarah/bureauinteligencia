<?php       
    require_once '../DatacenterDao.php';
    require_once '../DatacenterService.php';
    require_once '../DataGrouper.php';
    require_once '../Data.php';
    require_once '../BuilderFactory.php';
    require_once '../Builder.php';
    
    
    require_once '../Statistic/Statistic.php';
    require_once '../../../util/JsonResponse.php';
    
    require_once '../../generics/Param.php';
    require_once '../../generics/datacenter/Subgroup.php';
    require_once '../../generics/datacenter/Font.php';
    require_once '../../generics/datacenter/Variety.php';
    require_once '../../generics/datacenter/CoffeType.php';
    require_once '../../generics/datacenter/Country.php';    
    
    require_once '../DatacenterController.php';
?>
<?php        
    require_once '../../DataBase/Connection.php';
    require_once '../../../util/Maps/HashMap.php';       
?>
<?
    $repository = new DatacenterDao(Connection::connectToTest());        
    $service = new DatacenterService($repository);
    $statistic = new Statistic();
    $jsonResponse = new JsonResponse();
    $grouper = new DataGrouper();
    $factory = new BuilderFactory();        
    $controller = new DatacenterController($service, $statistic, $jsonResponse, $grouper, $factory); 
?>