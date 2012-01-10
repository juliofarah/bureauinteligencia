<?php
    require_once 'build.php';
    require_once '../TableBuilder.php';
    require_once '../TableJsonBuilder.php';
?>
<?php        
        require_once '../../DataBase/Connection.php';
        require_once '../../../util/Maps/HashMap.php';
        
        $repository = new DatacenterDao(Connection::connectToTest());        
        $service = new DatacenterService($repository);
        $statistic = new Statistic();
        $jsonResponse = new JsonResponse();
        $grouper = new DataGrouper();
        $factory = new BuilderFactory();        
        $controller = new DatacenterController($service, $statistic, $jsonResponse, $grouper, $factory);
        print_r($controller);
        
        echo '<br />';
        echo $controller->buildTableAsJson(1, 1, 1, 1, 1, 1, array(1989,1992));
        echo '<br /><br />';
        echo $controller->getTable(1, 1, 1, 1, 1, 1, array(1987,1998));
?>