<?php           
    require_once 'core/Datacenter/DatacenterDao.php';
    require_once 'core/Datacenter/DatacenterService.php';
    require_once 'core/Datacenter/DataGrouper.php';
    require_once 'core/Datacenter/Data.php';
    require_once 'core/Datacenter/BuilderFactory.php';
    require_once 'core/Datacenter/Builder.php';
    
    
    require_once 'core/Datacenter/Statistic/Statistic.php';    
    
    require_once 'core/generics/Param.php';
    require_once 'core/generics/datacenter/Subgroup.php';
    require_once 'core/generics/datacenter/Font.php';
    require_once 'core/generics/datacenter/Variety.php';
    require_once 'core/generics/datacenter/CoffeType.php';
    require_once 'core/generics/datacenter/Country.php';    
    
    require_once 'core/Datacenter/DatacenterController.php';
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